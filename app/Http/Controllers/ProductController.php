<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\User;

class ProductController extends Controller
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
        
        $barcode_no = $request->input('barcode_no');
        $sku = $request->input('sku');
        $category_no = $request->input('category_no');
        $product_name = $request->input('product_name');
        $product_unit = $request->input('product_unit');
        $product_description = $request->input('product_description');
        $product_photo_path = $request->input('product_photo');
    
        if($request->hasFile('product_photo')){
            $product_photo = $request->file('product_photo');
            $product_photo_name = $product_photo->getClientOriginalname();
            $product_photo_path = Storage::disk('product')->putFileAs('products', $product_photo, $product_photo_name); // disk('profile') set at filesystems.php, save at public/img under 'products' folder with a name 'test.jpg'
            
            // Storage::putFileAs('photos', $photo, 'test.jpg'); // save at storage under 'photos' folder with a name 'test.jpg'

        }

        $added = DB::table('tbl_product')->insert(
            [
                'id' => NULL,
                'barcode_no' => $barcode_no,
                'sku' => $sku,
                'category_no' => $category_no,
                'product_name' => $product_name,
                'product_unit' => $product_unit,
                'product_description' => $product_description,
                'product_photo' => $product_photo_path,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        $pr_inv_added = DB::table('tbl_product_inventory')->insert(
            [
                'id' => NULL,
                'barcode_no' => $barcode_no,
                'total_accumulated_stocks' => 0,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT',
                'activity' => 'Added New Product: '.$product_name.' with barcode no. '.$barcode_no,
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
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();

        $barcode_no = $request->input('barcode_no');
        $sku = $request->input('sku');
        $category_no = $request->input('category_no');
        $product_name = $request->input('product_name');
        $product_unit = $request->input('product_unit');
        $product_description = $request->input('product_description');
        $product_photo_path = $request->input('product_photo');

        if($request->hasFile('product_photo')){
            $product_photo = $request->file('product_photo');
            $product_photo_name = $product_photo->getClientOriginalname();
            $product_photo_path = Storage::disk('product')->putFileAs('products', $product_photo, $product_photo_name); // disk('profile') set at filesystems.php, save at public/img under 'products' folder with a name 'test.jpg'
            
        }

        $affected = DB::table('tbl_product')
              ->where('id', $id)
              ->update(
                  [
                      'barcode_no' => $barcode_no,
                      'sku' => $sku,
                      'category_no' => $category_no,
                      'product_name' => $product_name,
                      'product_unit' => $product_unit,
                      'product_description' => $product_description,
                      'product_photo' => $product_photo_path,
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT',
                'activity' => 'Edited Product: '.$product_name.' with barcode no. '.$barcode_no,
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

    public function get_product_list(){
        return DB::select( DB::raw("SELECT barcode_no, product_name FROM `tbl_product` ORDER BY `created_at` DESC;") );
    }

    public function get_product_info_list($barcode_no){
        return DB::table('tbl_product_info')
            ->select('*')
            ->where("barcode_no", "=", $barcode_no)
            ->get();
    }

    public function get_product_info_latest_details($barcode_no){
            return DB::select(DB::raw("SELECT a.barcode_no, c.expiry_date, a.original_price, a.selling_price, c.stocks_added, d.supplier_name 
                FROM `tbl_product_info` a, `tbl_stock_entry` b, `tbl_stock_entry_list` c, `tbl_supplier` d 
                WHERE 
                    a.stock_entry_no = b.stock_entry_no AND 
                    b.stock_entry_no = c.stock_entry_no AND 
                    a.stock_entry_no = c.stock_entry_no AND 
                    a.barcode_no = c.barcode_no AND 
                    b.supplier_id = d.supplier_id AND 
                    a.status = 1 AND
                    a.barcode_no = :barcode_no
                "), array('barcode_no' => $barcode_no) );
    }

    public function get_product_details($barcode_no){
        return DB::table('tbl_product as a')
            ->join('tbl_product_category as b', 'a.category_no', '=', 'b.category_no')
            ->select('a.id', 'a.barcode_no', 'a.sku', 'b.category_no', 'b.category_name', 'a.product_name', 'a.product_unit', 'a.product_description', 'a.product_photo')
            ->where("a.barcode_no", "=", $barcode_no)
            ->get();
    }

    public function update_status(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user = Auth::user();

        $product_info_id = $request->input('product_info_id');
        // $barcode_no = $request->input('barcode_no');
        // $stock_entry_no = $request->input('stock_entry_no');
        $selected_status = $request->input('selected_status');

        // QUERY CURRENT ACTIVATED PRICING STATUS
        $curr_stat = DB::table('tbl_product_info as a')
            ->select('id')
            ->where("status", "=", 1)
            ->get();

        $old_stat = DB::table('tbl_product_info')
              ->where('id', $curr_stat[0]->id)
              ->update(
                  [
                      'status' => '0',
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        // ACTIVATE NEW PRICING STATUS

        $new_stat = DB::table('tbl_product_info')
              ->where('id', $product_info_id)
              ->update(
                  [
                      'status' => $selected_status,
                      'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
        );

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'PRODUCT',
                'activity' => 'Activated New Pricing for the Product: '.$product_name.' with barcode no. '.$barcode_no,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        
        echo $new_stat;
    }

}
