<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewStockEntryController extends Controller
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

    public function get_stock_entry(){
        return DB::select( DB::raw("SELECT receipt_no, stock_entry_no, CONCAT(stock_entry_no, ' - ', DATE_FORMAT((created_at), '%M %D, %Y')) AS 'stock_with_date' FROM `tbl_stock_entry`;") );
    }

    public function get_stock_entry_details($stock_entry_no){
        return DB::table('tbl_stock_entry as a')
            ->join('tbl_supplier as b', 'a.supplier_id', '=', 'b.supplier_id')
            ->select('a.stock_entry_no', 'a.receipt_no', 'b.supplier_name', 'a.total_products_added', 'a.total_stocks_added', 'a.total_cost_of_receipt', 'a.created_at')
            ->where("stock_entry_no", "=", $stock_entry_no)
            ->get();
    }

    public function get_stock_entry_list($stock_entry_no){
        return DB::table('tbl_stock_entry_list as a')
            ->join('tbl_stock_entry as b', 'a.stock_entry_no', '=', 'b.stock_entry_no')
            ->join('tbl_product as c', 'a.barcode_no', '=', 'c.barcode_no')
            ->select('a.barcode_no', 'c.product_name', 'a.expiry_date', 'a.orig_cost_per', 'a.total_whlsale_cost', 'a.stocks_added')
            ->where("a.stock_entry_no", "=", $stock_entry_no)
            ->get();
    }
}
