<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eloquent ORM
        // $users = User::all();

        // Query Builder
        $users = DB::table('users')->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => [
                    'status' => 'OK',
                    'code' => 200,
                    'msg' => 'No Users Yet',
                    'data' => []
                ],
                'errors' => []
            ]);
        }

        return response()->json([
            'success' => [
                'status' => 'OK',
                'code' => 200,
                'msg' => 'Success get all data users',
                'data' => $users
            ],
            'errors' => []
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // cuma tampilan form yang mana datanya akan di proses di store()
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|max:10|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => [],
                'errors' => [
                    'status' => 'Bad Request',
                    'code' => 400,
                    'msg' => $validator->errors()
                ]
            ], 400);
        }

        // Eloquent ORM
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        // Query Builder
        $user = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => [
                'status' => 'Created',
                'code' => 201,
                'msg' => 'Success create new User',
                'data' => $user,
            ],
            'errors' => []
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // menunjukan tampilan detail dari user

        // Eloquent ORM
        // $user = User::where('id',$id)->first();

        // Query Builder
        $user = DB::table('users')->where('id', $id)->first();

        if (!isset($user)) {
            return response()->json([
                'success' => [],
                'errors' => [
                    'status' => 'Not Found',
                    'code' => 404,
                    'msg' => 'User not found'
                ]
            ], 404);
        }

        return response()->json([
            'success' => [
                'status' => 'OK',
                'code' => 200,
                'msg' => 'Success get specific user',
                'data' => $user
            ],
            'errros' => []
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        /* 
            hanya menunjukan tampilan edit dan 
            setiap kolom terisi data dari user sesuai id dan data akan di proses di update()
        */
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => [],
                'errors' => [
                    'status' => 'Bad Request',
                    'code' => 400,
                    'msg' => $validator->errors()
                ]
            ], 400);
        }

        // ORM
        // $user = User::findOrFail($id);
        // $user->update($request->all());

        // Query Builder
        DB::table('users')->where('id', $id)->update($request->all());
        $user = DB::table('users')->where('id', $id)->first();

        return response()->json([
            'success' => [
                'status' => 'OK',
                'code' => 200,
                'msg' => 'Success update user',
                'data' => $user,
            ],
            'errors' => []
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Eloquent ORM
        $user = User::where('id', $id)->first();

        $user->delete();

        // Query Builder
        // DB::table('users')->where('id', $id)->delete();

        return response()->json([
            'success' => [
                'status' => 'OK',
                'code' => 200,
                'msg' => 'User deleted successfully'
            ]
        ]);
    }
}
