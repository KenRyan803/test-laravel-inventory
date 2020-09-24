<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
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

    public function get_invoices(){
        return DB::select( DB::raw("SELECT sales_transaction_no, invoice_no FROM `tbl_sales_transaction`") );
    }

    public function get_invoice_transaction($invoice_no){
        return DB::select(DB::raw("SELECT a.sales_transaction_no, a.invoice_no, a.total_quantity, b.name, a.tax, a.accumulated_total, a.amount_tendered, a.change, a.created_at
                FROM `tbl_sales_transaction` a, `users` b
                WHERE 
                    a.admin_id = b.id AND
                    a.invoice_no = :invoice_no
                "), array(
                        'invoice_no' => $invoice_no
                    ) 
            );
    }

    public function get_invoice_transaction_details($invoice_no){
        return DB::select(DB::raw("SELECT a.barcode_no, b.product_name, b.product_unit, a.selling_price, a.quantity, a.total_amount
                FROM `tbl_sales_transaction_list` a, `tbl_product` b
                WHERE 
                    a.barcode_no = b.barcode_no AND
                    a.invoice_no = :invoice_no
                "), array(
                        'invoice_no' => $invoice_no
                    ) 
            );
    }
}
