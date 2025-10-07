<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Survey;
use GuzzleHttp\Client;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $query = Survey::latest();
        switch ($status) {
            case 'disable':
                $query->where('status', Status::SURVEY_DISABLE);
                break;
            case 'enable':
                $query->where('status', Status::SURVEY_ENABLE);
                break;
            case 'all':
                $query->whereIn('status', [Status::SURVEY_ENABLE, Status::SURVEY_DISABLE]);
                break;
            default:
                break;
        }
        if ($search) {
            $query->searchable(['title']);
        }
        $surveys = $query->with('author')->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Surveys';
       
        return view('Admin::survey.index', compact('surveys', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Create New Survey';
        return view('Admin::survey.create', compact('pageTitle'));
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = gs()->open_ai_key;

        $response = $this->generateSurveyJson($apiKey, $prompt);

        return response()->json($response);
    }

    protected function generateSurveyJson($apiKey, $prompt, $model = 'gpt-4o-mini', $temperature = 0.4)
    {
        $client = new Client();
        $messages = [
            [
                "role" => "system",
                "content" => "You are a professional survey generator. Use question types: mcq_single, mcq_multiple, both multiple-choice (single/multiple) and written written_textarea, written_input. Always respond with valid JSON only with valid JSON in the following exact schema. Do NOT change key names or structure. 
                The schema is:
                {
                    \"type\": \"object\",
                    \"properties\": {
                        \"title\": { \"type\": \"string\" },
                        \"questions\": {
                        \"type\": \"array\",
                        \"items\": {
                            \"type\": \"object\",
                            \"properties\": {
                            \"id\": { \"type\": \"integer\" },
                            \"type\": { \"enum\": [\"mcq_single\", \"mcq_multiple\", \"written_input\",\"written_textarea\"] },
                            \"question\": { \"type\": \"string\" },
                            \"options\": {
                                \"type\": \"array\",
                                \"items\": { \"type\": \"string\" },
                                \"minItems\": 2
                            },
                            \"placeholder\": { \"type\": \"string\" }
                            },
                            \"required\": [\"id\", \"type\", \"question\"],
                            \"allOf\": [
                            {
                                \"if\": {
                                \"properties\": {
                                    \"type\": { \"enum\": [\"mcq_single\", \"mcq_multiple\"] }
                                }
                                },
                                \"then\": {
                                \"required\": [\"options\"]
                                }
                            }
                            ]
                        },
                        \"uniqueItems\": true
                        }
                    },
                    \"required\": [\"title\", \"questions\"]
                }"
            ],
            ["role" => "user", "content" => $prompt]
        ];

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => $temperature,
                    'max_tokens' => 1200,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (!isset($result['choices'][0]['message']['content'])) {
                return [
                    'status' => 'error',
                    'message' => 'Empty response from OpenAI.',
                    'data' => null
                ];
            }

            // Remove ```json ``` fencing if present
            $content = trim($result['choices'][0]['message']['content']);
            $content = preg_replace('/^```json|```$/m', '', $content);
            $json = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid JSON format received.',
                    'data' => $content // raw text for debugging
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Survey generated successfully.',
                'data' => $json
            ];
        } catch (\Exception $e) {
            Log::error("OpenAI API Error: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'An error occurred while generating the survey.',
                'data' => null
            ];
        }
    }

    public function store(Request $request)
    {
        $data = $request->input('survey');
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'required|integer|distinct',
            'questions.*.type' => 'required|in:mcq_single,mcq_multiple,written_input,written_textarea',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'sometimes|array|min:2',
            'questions.*.options.*' => 'string'
        ]);

        // MCQ questions must have options
        foreach ($data['questions'] ?? [] as $q) {
            if (in_array($q['type'], ['mcq_single', 'mcq_multiple']) && empty($q['options'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Question ID {$q['id']} must have at least 2 options."
                ], 422);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $survey              = new Survey();
        $survey->author_id   = auth('admin')->id();
        $survey->author_type = Admin::class;
        $survey->title       = $data['title'];
        $survey->form_data   = $data;
        $survey->status      = Status::SURVEY_ENABLE;
        $survey->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Survey form data saved successfully.'
        ]);
    }

    public function details($id)
    {
        $survey = Survey::where('id', $id)->first();
        if (!$survey) {
            $notify[] = ['error', 'Survey Not Found'];
            return back()->withNotify($notify);
        }
   
        $pageTitle = 'Survey Details';
        return view('Admin::survey.details', compact('pageTitle', 'survey'));
    }



    public function status($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->status = $survey->status == 1 ? 0 : 1;
        $survey->save();
        $notify[] = ['success', 'Survey Status has been updated successfully'];
        return back()->withNotify($notify);
    }
}
