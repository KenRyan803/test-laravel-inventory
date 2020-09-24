<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'USERS',
                'activity' => 'Added user named '.$request->input('name').' to the system.',
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            // 'photo' => $request['photo'], dont include so that the default value will be used, otherwise NULL is the value
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Manila');
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',            
            // 'email' => 'required|string|email|max:191|unique:users,email,'.$user->id, same as below
            'email' => ['required',
                        'email',
                        'max:191',
                        Rule::unique('users')->ignore($user->id),
                    ],
            'password' => 'sometimes|min:8',
        ]);

        $user->update($request->all());

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $id,
                'from' => 'USERS',
                'activity' => 'Updated user named '.$request->input('name').'.',
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get user
        $user = User::findOrFail($id);

        // delete user
        $user->delete();
        
        return ['message' => 'User Deleted!'];
    }
}
