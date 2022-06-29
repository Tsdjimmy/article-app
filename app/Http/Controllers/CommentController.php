<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleServices;

class CommentController extends Controller
{
   
    public function createComment(Request $request)
    {
        return ArticleServices::createComment($request);
    }

    public function likes(Request $request)
    {
        return ArticleServices::likes($request);
    }
}
