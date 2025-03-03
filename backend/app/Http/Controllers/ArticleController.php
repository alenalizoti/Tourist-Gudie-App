<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getArticles(){
        $articles = Article::with('user','activities')->get();
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

        $article->activities()->detach();
        $article->delete();
        return response()->json(['message' => 'Article deleted successfully!'],200);
    }

    public function singleArticle($id){
        $article = Article::with('activities','destination','user')->find($id);

        if(!$article){
            return response()->json(['message' => 'Article not found!'],400);
        }

        return response()->json(['data' => $article, 'message' => 'Successfully fetching article'],200);
    }

    public function updateArticle($id, Request $request){
        $article = Article::find($id);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'activities' => 'array|required',
        ]);

        if(!$article){
            return response()->json(['message' => 'Article not found!'],400);
        }

        $article->title = $validateData['title'];
        $article->content = $validateData['content'];

        try{
            $article->save();
            $article->activities()->sync($validateData['activities']);
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
                'destination_id' => 'required',
                'activities' => 'required|array',
            ]);

            $article->title = $validateData['title'];
            $article->content = $validateData['content'];
            $article->destination_id = $validateData['destination_id'];
            $article->user_id = $request->user_id;
            $article->save();

            if (!empty($validateData['activities'])) {
                $article->activities()->attach($validateData['activities']);
            }

            return response()->json(['message' => 'New article is successfully created!'],200);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to create article.', 'error' => $e->getMessage()], 500);
        }
    }

    public function getArticlesByActivity($activityId){
        try{

            $articles = Article::whereHas('activities', function ($query) use ($activityId) {
                $query->where('activity.id', $activityId);
            })->with('user','activities')->get();
    
            if(!$articles){
                return response()->json(['message' => 'No articles found for this activity!'], 404);
            }
    
            return response()->json(['data' => $articles, 'message' => 'Articles fetched successfully'], 200);
        }
        catch(\Exception $e){
            \Log::error($e->getMessage()); 
            return response()->json(['message' => 'Server error!'], 500);
        }
    }

    public function getActivities(){
        $activities = Activity::all();

        if(!$activities){
            return response()->json(['message' => 'No activities found for this activity!'], 404);
        }

        return response()->json(['data' => $activities, 'message' => 'Successfully fethcing!'],200);
    }
    public function articlesByDestination($id){
        $articles = Article::find($id)->where('destination_id',$id)->with('activities','user','destination')->get();

        if(!$articles){
            return response()->json(['message' => 'No articles found for this activity!'], 404);
        }

        return response()->json(['data' => $articles, 'message' => 'Successfully fethcing!'],200);
    }

    public function newestArticles(){

        $articles = Article::with('activities','destination','user')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

        if ($articles->isEmpty()) {
            return response()->json(['message' => 'No articles found!'], 204);
        }

        return response()->json([
            'message' => 'Successfully fetched!',
            'data' => $articles
        ], 200);
    }

    public function readArticle($id){

    }
}
