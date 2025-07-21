<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $data_content = Voucher::orderByDesc('id')
            ->withCount('redeem');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function show($id)
    {
        $data = Voucher::find($id);

        $this->response['result'] = $data;
        return $this->response;
    }

    private function withFilter($data_content, Request $request)
    {
        if ($request->name) {
            $data_content = $data_content->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('code', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->type) {
            $data_content = $data_content->where('type', $request->type);
        }

        if ($request->year) {
            $data_content = $data_content->whereYear('created_at', $request->year);
        }

        if ($request->ref) {
            $data_content = $data_content->whereYear('created_at', $request->ref);
        }

        return $data_content;
    }

    public function store(Request $request)
    {
        $this->validateData($request);

        $this->response['result'] = Voucher::create($request->all());

        return $this->response;
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $this->validateData($request);

        $data = Voucher::find($request->id);
        if ($data) {
            $data->update($request->all());
            $this->response['message'] = 'Updated!';
        } else {
            $this->response['success'] = false;
            $this->response['message'] = 'Not Found';
        }

        return $this->response;
    }

    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['errors'] = $validator->errors();
            abort(response($this->response, 422));
        }
    }

    public function voucherRecap(Request $request)
    {

        $data_content = Voucher::orderByDesc('id')
            ->where('section', $request->section ?? 'jcu25')
            ->with('redeem');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        return view('print.voucher.voucher-recap', [
            'vouchers' => $data_content,
            'query' => $request->all(),
        ]);
    }
}
