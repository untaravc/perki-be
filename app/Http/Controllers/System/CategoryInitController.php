<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryInitController extends Controller
{
    public function categories_init()
    {
        $data = [
            [
                "category" => "Slider",
                "slug"     => "slider",
            ],
            [
                "category" => "Sponsor",
                "slug"     => "sponsor",
            ],
            [
                "category" => "Abstract",
                "slug"     => "abstract",
            ],
            [
                "category" => "News",
                "slug"     => "news",
            ],
        ];

        foreach ($data as $item) {
            $model = Category::whereSlug($item['slug'])->first();
            if ($model) {
                $model->update($item);
            } else {
                Category::create($item);
            }
        }
    }
}
