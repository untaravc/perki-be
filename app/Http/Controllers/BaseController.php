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

    public function sendError($response_code, $message = null, $errors = null )
    {
        switch ($response_code) {
            case 401:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? 'Unauthenticated. Please Register or Login.';
                abort(response()->json($this->response, 401));
            case 403:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? 'Forbidden email address.';
                abort(response()->json($this->response, 403));
            case 404:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? 'Data not found.';
                abort(response()->json($this->response, 404));
            case 422:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? "Data tidak sesuai.";
                if ($errors) {
                    $this->response['errors'] = $errors;
                }
                abort(response()->json($this->response, 422));
            default:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? 'Application Error. Message information not available.';
                abort(response()->json($this->response, 500));
        }
    }

    public function sendGetResponse($data, string $message = null)
    {
        abort(response()->json([
            'status'  => true,
            'message' => $message ?? 'Access data success',
            'result'  => $data,
        ]));
    }

    public function sendPostResponse(string $message = null, array $data = []){
        abort(response()->json([
            'status'  => true,
            'message' => $message ?? 'Create data success',
            'result'  => $data,
        ], 201));
    }

    public function sendPatchResponse(string $message = null, array $data = []){
        abort(response()->json([
            'status'  => true,
            'message' => $message ?? 'Update data success',
            'result'  => $data,
        ], 201));
    }

    public function sendDeleteResponse(string $message = null, array $data = []){
        abort(response()->json([
            'status'  => true,
            'message' => $message ?? 'Delete data success',
            'result'  => $data,
        ], 201));
    }
}
