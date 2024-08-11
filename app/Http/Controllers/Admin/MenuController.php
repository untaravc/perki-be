<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $dataContent = Menu::orderByDesc('created_at');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate($request->per_page ?? 20);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        if ($request->title) {
            $dataContent = $dataContent->where('title', 'LIKE', '%' . $request->title . '%');
        }
        return $dataContent;
    }

    public function store(Request $request)
    {
        $this->validateData($request);

        $this->response['result'] = Menu::create($request->all());

        return $this->response;
    }

    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url'   => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['errors'] = $validator->errors();
            abort(response($this->response, 422));
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $this->validateData($request);

        $data = Menu::find($request->id);
        if ($data) {
            $data->update($request->all());
            $this->response['message'] = 'Updated!';
        } else {
            $this->response['success'] = false;
            $this->response['message'] = 'Not Found';
        }

        return $this->response;
    }

    public function show($id)
    {
        $data = Menu::find($id);

        $this->response['result'] = $data;
        return $this->response;
    }

    public function destroy($id)
    {
        $data = Menu::find($id);
        if ($data) {
            $data->delete();
        }
        return $this->response;
    }

    public function list(Request $request)
    {
        $this->response['result'] = Menu::orderBy('title')
            ->when($request->type, function ($q) use ($request) {
                if ($request->type == 'main') {
                    $q->whereParentId(0);
                }
            })->get();
        return $this->response;
    }

    public function menuRole(Request $request)
    {
        $menu = Menu::get();

        $menu_role = MenuRole::whereRoleId($request->role_id)->pluck('menu_id')->toArray();

        for ($i = 0; $i < count($menu); $i++) {
            if (in_array($menu[$i]['id'], $menu_role)) {
                $menu[$i]['selected'] = true;
            } else {
                $menu[$i]['selected'] = false;
            }
        }

        $this->response['result'] = $this->buildTree($menu->toArray());
        return $this->response;
    }

    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function menuRoleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id'   => 'required',
            'menu_roles' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $menu_roles = $request->menu_roles;
        $selected = [];

        foreach ($menu_roles as $menu) {
            if ($menu['selected']) {
                $selected[] = $menu['id'];
            }

            if (isset($menu['children'])) {
                foreach ($menu['children'] as $child) {
                    if ($child['selected']) {
                        $selected[] = $child['id'];
                    }
                }
            }
        }

        $active_menu = MenuRole::whereRoleId($request->role_id)
            ->get();

        // dihapus
        $delete = [];
        foreach ($active_menu as $active) {
            if (!in_array($active['menu_id'], $selected)) {
                $delete[] = $active['menu_id'];
            }
        }

        // belum ditambah
        $create = [];
        foreach ($selected as $select) {
            if (!in_array($select, $active_menu->pluck('menu_id')->toArray())) {
                $create[] = $select;
            }
        }

        if (count($delete) > 0) {
            MenuRole::whereRoleId($request->role_id)
                ->whereIn('menu_id', $delete)
                ->delete();
        }

        if (count($create) > 0) {
            foreach ($create as $crt) {
                MenuRole::create([
                    'role_id' => $request->role_id,
                    'menu_id' => $crt
                ]);
            }
        }

        $this->response['result'] = [
            'selected'    => $selected,
            'active_menu' => $active_menu->pluck('id'),
            'delete'      => $delete,
            'create'      => $create,
        ];
        return $this->response;
    }
}
