<?php

namespace App\Http\Controllers\Admin;

use App\Models\Survey;
use GuzzleHttp\Client;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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
            $query->searchable(['month']);
        }
        $surveys = $query->paginate(getPaginate());
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
}
