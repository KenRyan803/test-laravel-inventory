<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class StockEntryController extends Controller
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

        $stock_entry_no = $request->input('stock_entry_no');
        $receipt_no = $request->input('receipt_no');
        $selected_supplier = $request->input('selected_supplier');
        $total_cost_of_receipt = $request->input('total_cost_of_receipt');

        $stock_entry_list_details_jsonstr = $request->input('stock_entry_list_details');
        $stock_entry_list_details_strjson = json_decode($stock_entry_list_details_jsonstr);

        $total_products_added = count($stock_entry_list_details_strjson);
        $total_stocks_added = 0;

        foreach($stock_entry_list_details_strjson as $se) {
            $total_stocks_added = $total_stocks_added + $se->stocks_added;
            
             $se_list_added = DB::table('tbl_stock_entry_list')->insert(
                 [
                     'stock_entry_list_id' => NULL,
                     'stock_entry_no' => $stock_entry_no,
                     'barcode_no' => $se->barcode_no,
                     'expiry_date' => $se->expiry_date,
                     'orig_cost_per' => $se->per_item_cost,
                     'total_whlsale_cost' => $se->tot_whsale_cost,
                     'stocks_added' => $se->stocks_added,
                     'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                     'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                 ]
             );

             $product_info_added = DB::table('tbl_product_info')->insert(
                 [
                     'id' => NULL,
                     'barcode_no' => $se->barcode_no,
                     'original_price' => $se->per_item_cost,
                     'markup_price_php' => $se->markup,
                     'selling_price' => $se->selling_price,
                     'discount_php' => $se->discount,
                     'status' => '0',
                     'stock_entry_no' => $stock_entry_no,
                     'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                     'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                 ]
             );

        }
        
        // INSERT TBL_STOCK_ENTRY
        $se_added = DB::table('tbl_stock_entry')->insert(
            [
                'stock_entry_id' => NULL, 
                'receipt_no' => $receipt_no,
                'stock_entry_no' => $stock_entry_no,
                'supplier_id' => $selected_supplier,
                'total_products_added' => $total_products_added,
                'total_stocks_added' => $total_stocks_added,
                'total_cost_of_receipt' => $total_cost_of_receipt,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // INSERT TBL_STOCK_INVENTORY
        
         $res = DB::table('systemlogs')->insert(
             [
                 'id' => NULL, 
                 'users_id' => $user->id,
                 'from' => 'STOCK ENTRY',
                 'activity' => 'STOCK ENTRY: '.$stock_entry_no.' RECORDED.',
                 'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
             'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
             ]
         );

        
        echo $res;
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
        //
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

    public function get_recent_stock_entry(){
        return DB::select( DB::raw("SELECT stock_entry_no, receipt_no, created_at FROM `tbl_stock_entry` ORDER BY `stock_entry_id` DESC;") );
  
    }
}
