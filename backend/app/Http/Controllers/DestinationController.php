<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function getDestinations(){
        $destinations = Destination::all();
        if($destinations){
            return response()->json(["destinations" => $destinations,"message" => "Successfully!"],200);
        }
        return response()->json(["message"=> "Fetching api failed!"],400);
    }
    public function deleteDestination($id){
        $destination = Destination::find($id);

        if(!$destination){
            return response()->json(['message' => 'Destination not found!'],404);
        }

        $articlesCount = Article::where("destination_id",$id)->count();
        if($articlesCount > 0){
            return response()->json(['message'=>'Cannot delete destination with associated articles'],400);
        }

        $destination->delete();
        return response()->json(['message' => 'Destination deleted successfully!'],200);
    }
}
