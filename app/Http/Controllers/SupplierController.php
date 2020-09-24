<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
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

        $supplier_id = $request->input('supplier_id');
        $supplier_name = $request->input('supplier_name');
        $supplier_address = $request->input('supplier_address');

        $added = DB::table('tbl_supplier')->insert(
            [
                'supplier_id' => NULL,
                'supplier_name' => $supplier_name,
                'supplier_address' => $supplier_address,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'SUPPLIER',
                'activity' => 'Added New Supplier: '.$supplier_name,
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
    public function update(Request $request, $supplier_id)
    {
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();

        $supplier_name = $request->input('supplier_name');
        $supplier_address = $request->input('supplier_address');

        $affected = DB::table('tbl_supplier')
              ->where('supplier_id', $supplier_id)
              ->update(
                  [
                      'supplier_name' => $supplier_name,
                      'supplier_address' => $supplier_address,
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'SUPPLIER',
                'activity' => 'Edited Supplier: '.$supplier_name,
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
    public function destroy(Request $request, $supplier_id)
    {
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();
        $supplier_name = $request->input('supplier_name');
        
        $deleted = DB::table('tbl_supplier')->where('supplier_id', '=', $supplier_id)->delete();

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'SUPPLIER',
                'activity' => 'Deleted Supplier: '.$supplier_name,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        echo $deleted;
    }

    public function get_supplier_list(){
        return DB::select( DB::raw("SELECT supplier_id, supplier_name, supplier_address, created_at FROM `tbl_supplier` ORDER BY `supplier_id` DESC;") );
    }

    public function get_supplier_list_cmb(){
        return DB::select( DB::raw("SELECT supplier_id, supplier_name FROM `tbl_supplier` ORDER BY `supplier_id` ASC;") );
    }
}
