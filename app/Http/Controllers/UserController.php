<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private  User $user;

    public function __construct(User $post)
    {
        $this->user = $post;
    }

    public function index()
    {
        //Params
        $limit = request('limit');

        if($limit){
            $data = User::paginate($limit);
        }else{
            $data = User::all();
        }
        return response()->json(
            $data
        );


    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);

        $data['password'] = Hash::make($data['password']);
        $this->user->create($data);

        return response()->json([
            $data,
            'message' => 'Registed with success.'
        ]);

    }


    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'email|required',
        ]);

        $this->user = $user;
        $data = $this->user->update($request->all());

        if($data){
            return response()->json([
                'message' => 'Updated with success.'
            ]);
        }else{
            return response()->json([
                'message' => 'Updating failed.'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->user = $user;
        $data = $this->user->delete();

        return response()->json([
            'message' => 'Deleted success.'
        ]);
    }
}
