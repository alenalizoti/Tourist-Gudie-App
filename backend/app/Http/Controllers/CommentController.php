<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{
    public function storeComment(Request $request){
        $comment = new Comment();
        try{
            $dataValidated = $request->validate([
                'article_id' => 'required|exists:article,id',
                'author_name' => 'required|min:5|string',
                'content' => 'required|min:6'
            ]);
    
            $comment->article_id = $dataValidated['article_id'];
            $comment->author_name = $dataValidated['author_name'];
            $comment->content = $dataValidated['content'];
            $comment->save();

            return response()->json(['message' => 'Comment created successfully!'],201);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to create comment.', 'error' => $e->getMessage()], 500);
        }
    }
    public function getComments($id){
        $comments = Comment::where('article_id',$id)->get();
        if(count($comments) == 0){
            return response()->json(['message' => 'Comments not found!'],404);
        }

        return response()->json(['data' => $comments,'message' => 'Fetch comments successfully!'],200);
    }
}
