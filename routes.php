<?php

use Illuminate\Support\Facades\Route;
use Winter\Storm\Support\Facades\Input;
use Vancoders\News\Models\Post;

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('posts', function () {
        return Post::with('image')
            ->take(Input::get("limit"))
            ->skip(Input::get("offset"))
            ->get();
    });
    Route::get('post/{id}', function ($id = null) {
        return Post::with('image')->where('id', $id)->get();
    });
});
