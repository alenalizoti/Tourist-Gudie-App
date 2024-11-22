<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(){
        $users = User::all();

        if(!$users){
            return response()->json(['message' => 'Users not found!'],400);
        }

        return response()->json(['data' => $users, 'message' => 'Users successfully fetched!'],200);
    }

    public function deleteUser($id){
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'User not found!'],400);
        }

        $user->articles()->delete();
        $user->delete();

        return response()->json(['message' => 'User and their articles have been deleted successfully.'], 200);
    }

    public function getUser($id){
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'User not found!'],400);
        }

        return response()->json(['data' => $user, 'message' => 'User successfully fetched!'],200);

    }

    public function updateUser($id, Request $request){
        $validateData = $request->validate([
            'name' => 'required|min:5|max:255|string',
            'email' => 'required|email|max:255',
            'status' => 'required',
            'user_type' => 'required',
        ]);

        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found!'],400);
        }

        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->status = $validateData['status'];
        $user->user_type = $validateData['user_type'];

        try{
            $user->save();
            return response()->json(['message' => 'Successfully updated!'],200);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to update user.', 'error' => $e->getMessage()], 500);
        }
    }
}
