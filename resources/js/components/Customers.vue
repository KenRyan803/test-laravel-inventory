<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">CUSTOMERS LIST</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap" id="dt_customer_list">
                                <thead>
                                    <tr style="text-align:center">
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        <th>Created</th>
                                        <th>Transaction History</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cus_list in customers_list" :key="cus_list.customer_id" style="text-align:center">
                                        <td>{{ cus_list.customer_id }}</td>
                                        <td>{{ cus_list.customer_name }}</td>
                                        <td>{{ cus_list.customer_name }}</td>
                                        <td>{{ cus_list.created_at }}</td>
                                        <td> 
                                            <a href="#" @click="customer_transactions_history(cus_list.customer_id)">
                                                <i class="fas fa-eye green"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="customer_transactions_modal" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CUSTOMER TRANSACTION RECORD</h5>
                    </div>

                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <v-select 
                                        :reduce="transactions_list => transactions_list.invoice_no"
                                        placeholder="Select customer transaction"
                                        label="invoice_with_date" 
                                        :options="transactions_list"
                                        @input="selected_transaction"
                                    >
                                    </v-select>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="transaction_no">Sales Transaction No</label>
                                        <input type="text" v-model="customer_invoice.sales_transaction_no" name="sales_transaction_no" class="form-control form-control-sm" disabled>
                                    </div>
                                
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="invoice">Invoice</label>
                                        <input type="text" v-model="customer_invoice.invoice_no" name="invoice_no" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="admin">Total Quantity</label>
                                        <input type="text" v-model="customer_invoice.total_quantity" name="total_quantity" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="admin">Admin | Created</label>
                                        <input type="text" v-model="customer_invoice.name" name="name" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                            </div>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap" id="dt_customer_trans_details">
                                        <thead>
                                            <tr style="text-align:center">
                                                <th>Quantity</th>
                                                <th>Barcode No</th>
                                                <th>Product Name</th>
                                                <th>Product Unit</th>
                                                <th>Selling Price</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cid in customer_invoice_details" :key="cid.barcode_no" style="text-align:center">
                                                <td>{{ cid.quantity }}</td>
                                                <td>{{ cid.barcode_no }}</td>
                                                <td>{{ cid.product_name }}</td>
                                                <td>{{ cid.product_unit }}</td>
                                                <td>{{ cid.selling_price }}</td>
                                                <td>{{ cid.total_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3 border-left">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item bg-dark pr-2 pb-0">
                                        <a class="float-right"><h2 class="text-success"><b>P {{ customer_invoice.accumulated_total }}</b></h2></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Discount</b> <a class="float-right"><h5 style="text-align:right;color:green">0.00</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Subtotal</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ solve_subtotal }}</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Tax amount</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ customer_invoice.tax }}</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Total</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ customer_invoice.accumulated_total }}</h5></a>
                                    </li>
                                    <li class="list-group-item mt-3">
                                        <b>Cash Tendered</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ customer_invoice.amount_tendered }}</h5></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Change</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ customer_invoice.change }}</h5></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                customers_list: [],
                transactions_list: [],
                customer_invoice: [],
                customer_invoice_details: [],
                sub_total: ''
            }
        },
        methods: {
            load_customer(){
                $("#dt_customer_list").DataTable().destroy();
                axios.get("customer/get_customer_list").then(
                    ({ data }) => {
                        this.customers_list = data
                        this.forceRefreshCustomersListDataTable();
                    });
            },
            customer_transactions_history(customer_id){
                axios.get("customer/get_transactions_list/"+customer_id).then(
                    ({ data }) => {
                        this.transactions_list = data
                    });

                $("#dt_customer_trans_details").DataTable().destroy();
                this.forceRefreshCustomerTransDataTable();  

                $('#customer_transactions_modal').modal('show');

            },
            selected_transaction(invoice_no){
                if(invoice_no === null){
                    this.customer_invoice = '';
                    this.sub_total = '';
                }else{
                    const get_invoice_details = axios.get("customer/get_invoice_details/"+invoice_no);
                    const get_customer_invoice_details = axios.get("customer/get_customer_invoice_details/"+invoice_no);

                    axios.all([get_invoice_details, get_customer_invoice_details ]).then(axios.spread((...data) => {
                        this.customer_invoice = data[0].data[0];
                        this.customer_invoice_details = data[1].data;

                        $("#dt_customer_trans_details").DataTable().destroy();
                        this.forceRefreshCustomerTransDataTable();  
                    })).catch(errors => {
                    // react on errors.
                    });

                }                 

            },
            forceRefreshCustomerTransDataTable() {
                Vue.nextTick(function () {
                    $("#dt_customer_trans_details").DataTable({
                        "ordering": false,
                        "paging": false,
                        "searching": false
                    }).draw();
                });
            },
            forceRefreshCustomersListDataTable() {
                Vue.nextTick(function () {
                    $("#dt_customer_list").DataTable({"ordering": false,}).draw();
                });
            },
        },
        computed: {
            solve_subtotal: function() {
                var tot = 0;
                var taxable = 0;
                this.sub_total = 0;

                if(this.customer_invoice === [] || this.customer_invoice === '' || this.customer_invoice === undefined || this.customer_invoice.length === 0){
                    this.sub_total = 0;
                }else{
                    tot = parseInt(this.customer_invoice.accumulated_total);
                    taxable = parseInt(this.customer_invoice.tax);

                    this.sub_total = tot - taxable;
                }

                return this.sub_total.toFixed(2);
            }
        },
        created() {
            this.load_customer();
        }
    }
</script>
