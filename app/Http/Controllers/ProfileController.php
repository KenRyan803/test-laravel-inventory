<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
        $name = $request->input('name');
        $email = $request->input('email');
        $path = $request->input('photo');
    
        if($request->hasFile('photo')){
            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalname();
            $path = Storage::disk('profile')->putFileAs('profiles', $photo, $photoName); // disk('profile') set at filesystems.php, save at public/img under 'profiles' folder with a name 'test.jpg'
            
            // Storage::putFileAs('photos', $photo, 'test.jpg'); // save at storage under 'photos' folder with a name 'test.jpg'

        }

        $affected = DB::table('users')
              ->where('id', $id)
              ->update(
                  [
                      'name' => $name,
                      'email' => $email,
                      'photo' => $path,
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $id,
                'from' => 'PROFILE',
                'activity' => 'Updated Profile and Profile Picture.',
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        echo $affected;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getinfo(){
        return Auth::user();
    }
}
