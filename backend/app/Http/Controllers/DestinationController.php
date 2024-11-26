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


    public function getDestination($id){
        $destination = Destination::find($id);

        if(!$destination){
            return response()->json(['message' => 'Destination not found!'],404);
        }

        return response()->json(['data' => $destination, 'message' => 'Destination found successfully!'],200);
    }

    public function updateDestination(Request $request,$id){
        $destination = Destination::find($id);

        if(!$destination){
            return response()->json(['message' => 'Destination not found!'],404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:destination,name',
            'description' => 'required|string',
        ]);

        $destination->name = $validatedData['name'];
        $destination->description = $validatedData['description'];
        

        try {
            $destination->save();
            return response()->json(['message' => 'Successfully updated!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update destination.', 'error' => $e->getMessage()], 500);
        }
    }

    public function addDestination(Request $request){
        $destination = new Destination();

        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string'
            ]);
    
            $destination->name = $validatedData['name'];
            $destination->description = $validatedData['description'];
            $destination->save();
            return response()->json(['message' => 'New destination is successfully created!'],200);
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() === '23000'){
                return response()->json(['message' => 'Destination already exist. Please use diferent name for destination.'],409);
            }
        }

    }
}
