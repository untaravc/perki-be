<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $response = [
        'status'  => true,
        'message' => null,
        'result'  => null,
    ];

    public function sendError($response_code, $message = null, $errors = null)
    {
        switch ($response_code) {
            case 404:
                $this->response['status'] = false;
                $this->response['message'] = 'Data not found.';
                return response()->json($this->response, 404);
            case 401:
                $this->response['status'] = false;
                $this->response['message'] = 'Unauthenticated. Please Register or Login.';
                return response()->json($this->response, 401);
            case 422:
                $this->response['status'] = false;
                $this->response['message'] = $message;
                if ($errors) {
                    $this->response['errors'] = $errors;
                }
                return response()->json($this->response, 422);
        }
    }

    public function sendResponse(int $response_code, $data, string $message = null)
    {
        switch ($response_code) {
            case 211:
                $message_response = $message ?? 'Data created.';
                break;
            case 212:
                $message_response = $message ?? 'Data updated.';
                break;
            case 213:
                $message_response = $message ?? 'Data deleted.';
                break;
            default:
                $message_response = $message ?? 'Access data success.';
        }

        return response()->json([
            'status'  => true,
            'message' => $message_response,
            'result'  => $data,
        ], $response_code);
    }
}
