<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
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
        //
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
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();

        $category_no = $request->input('category_no');
        $category_name = $request->input('category_name');
        $category_description = $request->input('category_description');

        $added = DB::table('tbl_product_category')->insert(
            [
                'category_no' => NULL,
                'category_name' => $category_name,
                'category_description' => $category_description,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT CATEGORY',
                'activity' => 'Added New Product Category: '.$category_name,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        echo $added;
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
    public function update(Request $request, $category_no)
    {
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();

        $category_name = $request->input('category_name');
        $category_description = $request->input('category_description');

        $affected = DB::table('tbl_product_category')
              ->where('category_no', $category_no)
              ->update(
                  [
                      'category_name' => $category_name,
                      'category_description' => $category_description,
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT CATEGORY',
                'activity' => 'Edited Product Category: '.$category_name,
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
    public function destroy(Request $request, $category_no)
    {
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();
        $category_name = $request->input('category_name');
        
        $deleted = DB::table('tbl_product_category')->where('category_no', '=', $category_no)->delete();

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT CATEGORY',
                'activity' => 'Deleted Product Category: '.$category_name,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        echo $deleted;
    }

    public function get_product_category(){
        return DB::select( DB::raw("SELECT category_no, category_name, category_description, created_at FROM `tbl_product_category` ORDER BY `category_no` DESC;") );
    }

}
