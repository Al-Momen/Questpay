<?php

namespace App\Http\Controllers\User;

use App\Models\User;
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
        $query = Survey::with('deposit')->where('author_id', auth()->id())->where('author_type', User::class)->latest();
        switch ($status) {
            case 'disable':
                $query->where('status', Status::SURVEY_DISABLE);
                break;
            case 'enable':
                $query->where('status', Status::SURVEY_ENABLE);
                break;
            case 'all':
                $query->whereIn('status', [Status::SURVEY_ENABLE, Status::SURVEY_DISABLE,Status::SURVEY_INITIAL]);
                break;
            default:
                break;
        }
        if ($search) {
            $query->searchable(['title']);
        }
        $surveys = $query->with('author')->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Surveys';
        return view('UserTemplate::survey.index', compact('surveys', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'New Survey Create';
        session()->forget('survey_data');
        return view('UserTemplate::survey.create', compact('pageTitle'));
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = gs()->open_ai_key;

        if (gs()->credit_cost_per_prompt > auth()->user()->credit) {

            return response()->json([
                'status' => 'error',
                'message' => 'You do not have enough credits.',
                'data' => null
            ]);
        }

        $response = $this->generateSurveyJson($apiKey, $prompt);

        if($response['status'] == 'success'){
            $user = auth()->user();
            $user->credit -= gs()->credit_cost_per_prompt;
            $user->save();
        }

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
                    'data' => $content 
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
        $data      = $request->except('_token');
        $validator = Validator::make($data, [
            'survey_people'                => 'required|numeric|min:1',
            'survey_money'                 => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'total_question'               => 'required|numeric|min:1',
            'survey.title'                 => 'required|string|max:255',
            'survey.questions'             => 'required|array|min:1',
            'survey.questions.*.id'        => 'required|integer|distinct',
            'survey.questions.*.type'      => 'required|in:mcq_single,mcq_multiple,written_input,written_textarea',
            'survey.questions.*.question'  => 'required|string',
            'survey.questions.*.options'   => 'sometimes|array|min:2',
            'survey.questions.*.options.*' => 'string'
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

        if (count($request["survey"]['questions']) < 0) {
            return response()->json([
                'status' => 'error',
                'message' => "Question must have at least 1."
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

         session()->put('survey_data', [
            'survey_people'  => $request->input('survey_people'),
            'survey_money'   => $request->input('survey_money'),
            'total_question' => isset($data['survey']['questions']) ? count($data['survey']['questions']) : 0,
            'title'          => $data['survey']['title'] ?? null,
            'form_data'      => $data['survey'] ?? [],
        ]);
         

        

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
        return view('UserTemplate::survey.details', compact('pageTitle', 'survey'));
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
