<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class POSController extends Controller
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

        $trans_list_of_products = $request->input('trans_list_of_products');
        $trans_list_of_products_decoded = json_decode($trans_list_of_products);

        $customer_details = $request->input('customer_details');
        $customer_details_decoded = json_decode($customer_details);
        
        $sales_trans_no = $request->input('sales_trans_no');
        $invoice_no = $request->input('invoice_no');
        $total_quantity = $request->input('total_quantity');
        $tax = $request->input('tax');
        $accumulated_total = $request->input('accumulated_total');
        $amount_tendered = $request->input('amount_tendered');
        $change = $request->input('change');
        $customer_if = $request->input('customer_if'); // 0 means existing customer, 1 meaning add customer

        foreach($trans_list_of_products_decoded as $tlpd) {
            $sales_trans_list = DB::table('tbl_sales_transaction_list')->insert(
                [
                    'sales_transaction_list_id' => NULL,
                    'invoice_no' => $invoice_no,
                    'barcode_no' => $tlpd->barcode_no,
                    'quantity' => $tlpd->quantity,
                    'selling_price' => $tlpd->selling_price,
                    'total_amount' => $tlpd->amount,
                    'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                    'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
        }

        $sales_trans = DB::table('tbl_sales_transaction')->insert(
            [
                'sales_transaction_no' => NULL, 
                'invoice_no' => $invoice_no,
                'admin_id' => $user->id,
                'total_quantity' => $total_quantity,
                'tax' => $tax,
                'accumulated_total' => $accumulated_total,
                'amount_tendered' => $amount_tendered,
                'change' => $change,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        if($customer_if === 0){
            $customer_trans = DB::table('tbl_customers_transaction')->insert(
                [
                    'customer_transaction_id' => NULL,
                    'customer_id' => $customer_details_decoded->customer_id,
                    'invoice_no' => $invoice_no,
                    'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                    'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
        }else{
            $customer_add_id = DB::table('tbl_customer')->insertGetId(
                [
                    'customer_id' => NULL,
                    'customer_name' => $customer_details_decoded->new_customer_name,
                    'customer_address' => $customer_details_decoded->new_customer_address,
                    'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                    'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );

            $customer_trans = DB::table('tbl_customers_transaction')->insert(
                [
                    'customer_transaction_id' => NULL,
                    'customer_id' => $customer_add_id,
                    'invoice_no' => $invoice_no,
                    'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                    'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
        }

        $res = DB::table('systemlogs')->insert(
            [
                'id' => NULL, 
                'users_id' => $user->id,
                'from' => 'POINT OF SALE',
                'activity' => 'INVOICE NO: '.$sales_trans_no.' RECORDED.',
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // dd($customer_details_decoded);
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

    public function get_customers(){
        return DB::select( DB::raw("SELECT customer_id, customer_name, customer_address FROM `tbl_customer` ORDER BY `customer_id` DESC;") );
    }

    public function get_product_listing(){
        return DB::select( DB::raw("SELECT a.barcode_no, a.product_name, a.product_unit, b.selling_price 
                        FROM `tbl_product` a, `tbl_product_info` b 
                        WHERE a.barcode_no = b.barcode_no AND
                            b.status = 1
                        ORDER BY b.id DESC;") );
    }

    public function get_sales_transaction_no(){
        return DB::select( DB::raw("SELECT MAX(sales_transaction_no)'max_sales_trans_id' FROM `tbl_sales_transaction`") );
    }
}
