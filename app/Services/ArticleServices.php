<?php


namespace App\services;

use App\Models\Log;
use App\Models\Like;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleServices
{
    public static function createArticle($request)
    {
        try {
            $rules = [
                'title' => 'required',
                'short_description' => 'required',
                ];
    
            $validate = Validator::make($request->input(), $rules, "Input is required");
    
            if ($validate->failed())
                return response()->json(array('message' => $validate->errors()->first()), 400);

            $title = $request->title;
            $short_description = $request->short_description;
            $thumbnail = $request->thumbnail;

            $article = new Article();
            $article->title = $title;
            $article->short_description = $short_description;
            $article->thumbnail = $thumbnail;
            $article->save();

            return response()->json(['message' => 'Article created successfully'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function Article($id)
    {
        try {
            // $id = $request->input('id');
            $article = Article::where('id', $id)->first();
            
            $log = new Log();
            $log->article_id = $id;
            $log->save();
            
            return response()->json(['message' => 'Article fetched successfully', 'data' => $article], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function Logview($request)
    {
        try {
            $id = $request->id;
            $times_logged = Log::where('article_id', $id)->get();
            $times = count($times_logged);
            return response()->json(['message' => 'Fethed Successfully', 'viewed' => $times], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function allArticles($request)
    {
        try {
            $article = Article::orderBy('id', 'DESC')->paginate(20);
            
            return response()->json(['message' => 'Articles fetched successfully', 'data' => $article], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function createComment($request)
    {
        try {
            // $rules = [
            //     'subject' => 'required',
            //     'body' => 'required',
            //     ];
    
            // $validate = Validator::make($request->input(), $rules, "Input is required");
    
            // if ($validate->failed())
            //     return response()->json(['message' => $validate->errors()->first()], 400);

            $id = $request->id;
            $newComment = new Comment();
            $newComment->subject = $request->input('subject');
            $newComment->body = $request->input('body');
            $newComment->article_id = $id;
            $newComment->save();

            $comments = Comment::where('article_id', $id)->get();

            return response()->json(['message' => 'Comment added successfully', 'data' => $comments], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function comment($request)
    {
        try {
            $id = $request->id;
            $comments = Comment::where('article_id', $id)->get();

            return response()->json(['message' => 'Articles fetched successfully', 'data' => $comments], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function likes($request)
    {
        try {
            $id = $request->id;
            $like = new Like();
            $like->article_id = $id;
            $like->save();

            $likes = Like::where('article_id', $id)->get();
            $total_likes = count($likes);
            return response()->json(['message' => 'You liked this article', 'Likes' => $total_likes], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }

    public static function viewArticle($request)
    {
        try {
            $id = $request->id;
            $article = Article::find($id)->get();
            
            return response()->json(['message' => 'Article fetched successfully', 'data' => $article], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred accessing your account',
                'short_description' => $e->getMessage(),
            ], 400);
        }

    }
}