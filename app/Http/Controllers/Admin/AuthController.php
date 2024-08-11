<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\MenuController;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login_view()
    {
        return view('admin.Login');
    }

    public function login(Request $request)
    {
        $this->response['success'] = false;

        $message = 'Email atau password salah.';
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $message . '01';
            return $this->response;
        }

        $user = User::whereEmail($request->email)
            ->whereIn('type', [
                'admin',
                'reviewer'
            ])
            ->first();

        if (!$user) {
            $this->response['message'] = $message . '02';
            return $this->response;
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->response['message'] = $message . '03';
            return $this->response;
        }

        $token = $user->createToken('admin');

        $user->update([
            'last_login' => now(),
        ]);

        $this->response['success'] = true;
        $this->response['result'] = [
            'token' => $token->plainTextToken,
            'user'  => $user
        ];

        return $this->response;
    }

    public function profile(Request $request)
    {
        $data = $request->user()->only(['id', 'name', 'email', 'type', 'nik']);
        $this->sendGetResponse($data);
    }

    public function adminPanel()
    {
        return view('admin.Layout');
    }

    public function notFound()
    {
        return view('404');
    }

    public function scannerPanel()
    {
        return view('admin.Scanner');
    }

    public function auth()
    {
        return view('admin.auth');
    }

    public function authJson(Request $request)
    {
        $user = $request->user();

        $result = User::with(['role'])->find($user['id']);

        $this->response['result'] = $result;
        return $this->response;
    }

    public function menu(Request $request)
    {
        $user = $request->user();

        $role_id = $user['role_id'];
        $menu_ids = MenuRole::whereRoleId($role_id)->pluck('menu_id');

        $menus = Menu::whereIn('id', $menu_ids)
            ->orderBy('order')
            ->get()->toArray();

        $menu_ctrl = new MenuController();
        $menu_tree = $menu_ctrl->buildTree($menus);

        $this->response['result'] = $menu_tree;
        return $this->response;
    }
}
