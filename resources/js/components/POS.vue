<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">TRANSACTION DETAILS</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="transaction_no">Sales Transaction No</label>
                                    <input type="text" v-model="sales_trans_no" name="sales_trans_no" class="form-control form-control-sm">
                                </div>
                            
                            </div>
                            <div class="col-md-5">                                
                                <div class="form-group">
                                    <label for="invoice">Invoice</label>
                                    <input type="text" v-model="sample_invoice_no" name="invoice" class="form-control form-control-sm" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">                                        
                                <div class="form-group">
                                    <label for="admin">Admin</label>
                                    <input type="text" v-model="current_user" name="admin" class="form-control form-control-sm" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">TRANSACTION</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <v-select 
                                                v-model="add_product"
                                                placeholder="Select Product"
                                                label="product_name" 
                                                :key="add_product.barcode_no"
                                                :options="products_list_cmb"
                                                @input="selected_product"
                                            >
                                            </v-select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12">
                                        <button class="btn btn-primary float-right">ADD PRODUCT</button>
                                    </div> -->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-nowrap" id="dt_trans_details">
                                                <thead>
                                                    <tr style="text-align:center">
                                                        <th>Quantity</th>
                                                        <th>Barcode No</th>
                                                        <th>Product Name</th>
                                                        <th>Product Unit</th>
                                                        <th>Selling Price</th>
                                                        <th>Amount</th>
                                                        <th><i class="nav-icon fas fa-cog"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="tlpd in transaction_list_products_details" :key="tlpd.barcode_no" style="text-align:center">
                                                        <td>{{ tlpd.quantity }}</td>
                                                        <td>{{ tlpd.barcode_no }}</td>
                                                        <td>{{ tlpd.product_name }}</td>
                                                        <td>{{ tlpd.product_unit }}</td>
                                                        <td>{{ tlpd.selling_price }}</td>
                                                        <td>{{ tlpd.amount }}</td>
                                                        <td>
                                                            <a href="#">
                                                                <i class="fas fa-edit orange"></i>
                                                            </a>
                                                            |
                                                            <a href="#" @click.prevent="delete_transaction_detail(tlpd.barcode_no)">
                                                                <i class="fas fa-trash red"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-3 border-left">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item bg-dark pr-2 pb-0">
                                        <a class="float-right"><h2 class="text-success"><b>P {{ solve_ovrall_total }}</b></h2></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Discount</b> <a class="float-right"><h5 style="text-align:right;color:green">0.00</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Subtotal</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ sub_total }}</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Tax amount</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ taxable }}</h5></a>
                                    </li>
                                     <li class="list-group-item">
                                        <b>Total</b> <a class="float-right"><h5 style="text-align:right;color:green">{{ solve_ovrall_total }}</h5></a>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" v-model="date_now" name="transaction_id" class="text-center form-control form-control-lg" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button class="btn btn-block btn-success" @click="record_transaction"><strong>RECORD TRANSACTION</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="record_transaction_modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">RECORD TRANSACTION</h5>
                    </div>

                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-4 bg-light">
                                <h5 class="mt-2 mb-3">
                                    <b>CUSTOMER</b> 
                                    <span class="float-right">
                                        <button class="btn btn-sm btn-secondary mb-1" @click="customer_add">ADD</button>
                                    </span>
                                </h5>
                                <hr class="mt-0">
                                <div class="form-group">
                                    <v-select 
                                        v-model="add_existing_customer"
                                        placeholder="Select Customer"
                                        label="customer_name" 
                                        :options="customer_list_cmb"
                                        @input="selected_customer"
                                    >
                                    </v-select>
                                </div>
                                <div class="form-group" v-if="add_customer_if === 0">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" v-model="add_existing_customer.customer_name" id="customer_name" name="customer_name" class="form-control form-control-sm" disabled>
                                </div>

                                <div class="form-group" v-else>
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" v-model="add_customer.new_customer_name" id="customer_name" name="customer_name" class="form-control form-control-sm">
                                </div>
                                <div class="form-group" v-if="add_customer_if === 0">
                                    <label for="customer_address">Customer Address</label>
                                    <textarea type="text" v-model="add_existing_customer.customer_address" id="customer_address" name="customer_address" row="4" class="form-control form-control-sm" disabled></textarea>
                                </div>
                                <div class="form-group" v-else>
                                    <label for="customer_address">Customer Address</label>
                                    <textarea type="text" v-model="add_customer.new_customer_address" id="customer_address" name="customer_address" row="4" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mt-2"><b>TENDER PAYMENT</b></h5>
                                <hr class="mt-0">
                                <ul class="list-group list-group-unbordered">
                                     <li class="list-group-item bg-dark p-2 pt-4">
                                        <b>Total Due</b> <a class="float-right"><h2 class="text-success">P {{ solve_ovrall_total }}</h2></a>
                                    </li>
                                    <li class="list-group-item bg-dark p-2 pt-4">
                                        <b>Cash</b> <a class="float-right"><input type="text" v-model="cash_tendered" id="cash_tendered" name="cash_tendered" class="form-control form-control-lg text-right">
                                </a>
                                    </li>
                                    <li class="list-group-item bg-dark p-2 pt-4">
                                        <b>Change</b> <a class="float-right"><h4 class="text-secondary"> {{ change_from_cash_tendered }} </h4></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="save_transaction">RECORD </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="add_product_transaction_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Product name</b> <a class="float-right">{{ add_product.product_name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Selling Price</b> <a class="float-right">{{ add_product.selling_price }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Quantity</b> <a class="float-right"><input v-model="product_quantity" class="form-control form-control-lg text-right"></a>
                                </li>
                                 <li class="list-group-item">
                                    <b>Total</b> <a class="float-right">{{ solve_amount }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="add_quantity_to_product">OK</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        data(){
            return{
                add_product: 0,
                add_customer_if: 0,
                add_customer: {
                    new_customer_name: '',
                    new_customer_address: '',
                }, 
                add_existing_customer: '', // returns object if customer is selected
                customer_list_cmb: [],
                products_list_cmb: [],
                transaction_list_products_details_holder: [],
                transaction_list_products_details: [],
                product_quantity: 0,
                product_amount_multiply_quantity: 0,
                current_user: '',
                sales_trans_no: '',
                invoice_no: '',
                sub_total: 0,
                taxable: 0,
                ovrall_total: 0,
                total_quantity: 0,
                cash_tendered: 0,
                change: 0,
            }
        },
        methods: {
            loadInformation(){
                const getauth = axios.get("systemlog/getauth");
                const get_customers = axios.get("pointofsale/get_customers");
                const get_product_listing = axios.get("pointofsale/get_product_listing");
                const get_sales_transaction_no = axios.get("pointofsale/get_sales_transaction_no");

                axios.all([getauth, get_customers, get_product_listing, get_sales_transaction_no]).then(axios.spread((...data) => {
                    this.current_user = data[0].data;
                    this.customer_list_cmb = data[1].data;
                    this.products_list_cmb = data[2].data;

                    if(data[3].data[0]['max_sales_trans_id'] === null){
                        this.sales_trans_no = 1;
                    }else{
                        this.sales_trans_no = parseInt(data[3].data[0]['max_sales_trans_id']) + 1;
                    }
                    // use/access the results 
                })).catch(errors => {
                // react on errors.
                });
            },
            record_transaction(){
                $('#record_transaction_modal').modal('show');
            },
            delete_transaction_detail(tlpd_barcode_no){
                const resultIndex = this.transaction_list_products_details.findIndex( ({ barcode_no }) => barcode_no === tlpd_barcode_no);

                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue delete this transaction entry?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    if (result.value) {
                        this.transaction_list_products_details.splice(resultIndex, 1);

                        $("#dt_trans_details").DataTable().destroy();
                        this.forceRefreshTransDataTable();
                    }
                })

            },
            selected_customer(customer){
                console.log(customer)
                if(customer === null){
                    this.add_customer_if = 0;
                    this.add_existing_customer = '';
                }else{
                    this.add_customer_if = 0;
                    this.add_customer.new_customer_name = '';
                    this.add_customer.new_customer_address = '';

                    this.add_existing_customer.customer_id = customer.customer_id;
                    this.add_existing_customer.customer_name = customer.customer_name;
                    this.add_existing_customer.customer_address = customer.customer_address;
                }
            },
            customer_add(){
                this.add_customer_if = 1;
                this.add_existing_customer = '';

            },
            selected_product(product){                
                if(product === null){
                    this.add_product = '';
                    // Toast2.fire({
                    //     icon: 'warning',
                    //     title: 'Product added already!'
                    // })  
                }else{
                    this.transaction_list_products_details_holder.push({ 
                        barcode_no: product.barcode_no,
                        product_name: product.product_name,
                        product_unit: product.product_unit,
                        selling_price: product.selling_price,
                    });
                    
                    $('#add_product_transaction_modal').modal('show');
                    
                }

            }, 
            add_quantity_to_product(){
                if(this.product_quantity === 0){
                    
                }else{
                    const result = this.transaction_list_products_details.find( ({ barcode_no }) => barcode_no === this.add_product.barcode_no);
                    const resultIndex = this.transaction_list_products_details.findIndex( ({ barcode_no }) => barcode_no === this.add_product.barcode_no);


                    if(result){
                        var new_amount = parseFloat(result.amount) + parseFloat(this.product_amount_multiply_quantity)
                        var new_quantity = parseInt(result.quantity) + parseInt(this.product_quantity)


                        this.transaction_list_products_details.splice(resultIndex, 1, {
                            barcode_no: this.add_product.barcode_no,
                            product_name: this.add_product.product_name,
                            product_unit: this.add_product.product_unit,
                            selling_price: this.add_product.selling_price,
                            quantity: new_quantity,
                            amount: new_amount.toFixed(2)
                        });

                        this.product_quantity = 0;
                        this.product_amount_multiply_quantity = 0;
                        this.add_product = '';

                        $("#dt_trans_details").DataTable().destroy();
                        this.forceRefreshTransDataTable();

                        $('#add_product_transaction_modal').modal('hide');
                        
                    }else{
                        this.transaction_list_products_details.push({ 
                            barcode_no: this.add_product.barcode_no,
                            product_name: this.add_product.product_name,
                            product_unit: this.add_product.product_unit,
                            selling_price: this.add_product.selling_price,
                            quantity: this.product_quantity,
                            amount: this.product_amount_multiply_quantity
                        });

                        this.product_quantity = 0;
                        this.product_amount_multiply_quantity = 0;
                        this.add_product = '';
                        
                        $("#dt_trans_details").DataTable().destroy();
                        this.forceRefreshTransDataTable();

                        $('#add_product_transaction_modal').modal('hide');
                    }
                }
                
            },
            save_transaction(){
                var customer_details_json = '';

                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue recording transaction?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {                    
                    if (result.value) {
                        this.$Progress.start();
                        var trans_list_products_details_json = JSON.stringify(this.transaction_list_products_details);

                        if(this.add_existing_customer === '' || this.add_existing_customer === null){
                            customer_details_json = JSON.stringify(this.add_customer);
                        }else{
                            customer_details_json = JSON.stringify(this.add_existing_customer);
                        }

                        axios({
                            method: 'post', 
                            url: 'pointofsale/',
                            data: {
                                sales_trans_no: this.sales_trans_no,
                                invoice_no: this.invoice_no,
                                trans_list_of_products: trans_list_products_details_json,
                                total_quantity: this.total_quantity,
                                tax: this.taxable,
                                accumulated_total: this.ovrall_total,
                                amount_tendered: this.cash_tendered,
                                change: this.change,
                                customer_details: customer_details_json,
                                customer_if: this.add_customer_if

                            }
                        }).then(({data})=>{
                            if(Number(data) == 1) {
                                $("#dt_trans_details").DataTable().destroy();
                                this.forceRefreshTransDataTable();  

                                $('#record_transaction_modal').modal('hide')

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaction recorded successfully!'
                                })  

                                this.$Progress.finish();
                                
                                this.loadInformation();
                                this.$router.go(0);
                            }else{
                                Toast.fire({
                                    icon: 'danger',
                                    title: 'Something went wrong!'
                                })  
                            }                           

                        })
                        .catch(()=>{
                            this.$Progress.fail();
                        });
                    }
                })
            },
            forceRefreshTransDataTable() {
                Vue.nextTick(function () {
                    $("#dt_trans_details").DataTable().destroy();
                    $("#dt_trans_details").DataTable({
                        "ordering": false,
                        "paging": false,
                        "searching": false
                    }).draw();
                });
            },
        },
        computed: {
            date_now: function() { 
                return moment(Date.now()).format('MMMM Do YYYY, h:mm:ss a');
                 
            },
            sample_invoice_no: function() {
                // this.stock_entry_details.stock_entry_no = Date.now();
                this.invoice_no = Date.now();
                return this.invoice_no;
            },
            solve_amount: function() {
                let amount = 0;
                amount = parseFloat(this.product_quantity) * parseFloat(this.add_product.selling_price);
                this.product_amount_multiply_quantity = amount.toFixed(2);
                return amount.toFixed(2);
            },
            solve_ovrall_total: function() {
                this.ovrall_total = 0;
                this.sub_total = 0;
                this.taxable = 0;
                this.total_quantity = 0

                this.transaction_list_products_details.forEach((element) => {
                    this.total_quantity = this.total_quantity + parseInt(element.quantity);
                });

                let tax = 0;
                let subtotal = 0;
                
                this.transaction_list_products_details.forEach((element) => {
                    this.ovrall_total = this.ovrall_total + parseInt(element.amount);
                });

                tax = parseInt(this.ovrall_total) * 0.12;
                this.taxable = tax.toFixed(2);
                subtotal = this.ovrall_total - this.taxable;
                this.sub_total = subtotal.toFixed(2);


                return this.ovrall_total.toFixed(2);
            },
            change_from_cash_tendered: function() {
                this.change = 0;
                let ch = 0;

                ch = parseFloat(this.cash_tendered) - this.ovrall_total;
                this.change = ch.toFixed(2);

                return ch.toFixed(2);
            },
        },
        created() {
            this.loadInformation();
            this.forceRefreshTransDataTable();
        }
    }
</script>
