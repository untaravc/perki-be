<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $response = [
        'status'  => true,
        'message' => null,
        'result'  => null,
    ];

    public function response($response_code, $message = null, $errors = null){
        switch ($response_code){
            case 404:
                $this->response['status'] = false;
                $this->response['message'] = $message ?? 'Data not found.';
                return response()->json($this->response, 404);
            case 401:
                $this->response['status'] = false;
                $this->response['message'] = 'Unauthenticated. Please Register or Login.';
                return response()->json($this->response, 401);
            case 422:
                $this->response['status'] = false;
                $this->response['message'] = $message;
                if($errors){
                    $this->response['errors'] = $errors;
                }
                return response()->json($this->response, 422);
            case 211:
                $this->response['message'] = 'Data created.';
                return response()->json($this->response);
            case 212:
                $this->response['message'] = 'Data updated.';
                return response()->json($this->response);
            case 213:
                $this->response['message'] = 'Data deleted.';
                return response()->json($this->response);
        }
    }

    public function responseErrors($message, $errors = null){
        $this->response['status'] = false;
        $this->response['message'] = $message;
        if($errors){
            $this->response['errors'] = $errors;
        }

        return response()->json($this->response, 422);
    }

    public function responseUpdate($data, $message = null){
        return response()->json([
            'status' => true,
            'message' => $message ?? 'Data updated.',
            'result' => $data,
        ], 201);
    }

    public function responseCreate($data, $message = null){
        return response()->json([
            'status' => true,
            'message' => $message ?? 'Data created.',
            'result' => $data,
        ], 201);
    }
}
