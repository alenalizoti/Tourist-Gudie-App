<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getArticles(){
        $articles = Article::with('user')->get();
        if(!$articles){
            return response()->json(['message' => 'Articles not found!'],404);
        }
        return response()->json(['data' => $articles,'message' => 'Successfully fetching articles'],200);
    }

    public function deleteArticle($id){
        $article = Article::find($id);

        if(!$article){
            return response()->json(['message' => 'Article not found!'],400);
        }

        $article->delete();
        return response()->json(['message' => 'Article deleted successfully!'],200);
    }

    public function singleArticle($id){
        $article = Article::find($id);

        if(!$article){
            return response()->json(['message' => 'Article not found!'],400);
        }

        return response()->json(['data' => $article, 'message' => 'Successfully fetching article'],200);
    }

    public function updateArticle($id, Request $request){
        $article = Article::find($id);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if(!$article){
            return response()->json(['message' => 'Article not found!'],400);
        }

        $article->title = $validateData['title'];
        $article->content = $validateData['content'];

        try{
            $article->save();
            return response()->json(['message' => 'Successfully updated!'],200);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to update article.', 'error' => $e->getMessage()], 500);
        }

    }
    public function addArticle(Request $request){
        $article = new Article();

        try{
            $validateData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'destination_id' => 'required'
            ]);

            $article->title = $validateData['title'];
            $article->content = $validateData['content'];
            $article->destination_id = $validateData['destination_id'];
            $article->user_id = $request->user_id;
            $article->save();
            return response()->json(['message' => 'New article is successfully created!'],200);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to create article.', 'error' => $e->getMessage()], 500);
        }
    }
}
