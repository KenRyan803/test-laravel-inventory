<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mt-3">            
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">STOCK ENTRY</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prod_cost">Stock Entry No</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" v-model="sample_stock_entry_no" name="stock_entry_no" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prod_price">Receipt No</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" v-model="stock_entry_details.receipt_no" name="receipt_no" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prod_price">Date</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" v-model="date_now" name="date_added" class="form-control form-control-sm" disabled>
                                        </div>                                
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="supplier">Supplier</label>                                        
                                            <v-select 
                                                :reduce="supplier_options => supplier_options.supplier_id"
                                                placeholder="Select a Supplier"
                                                label="supplier_name" 
                                                :options="supplier_options"
                                                @input="selectedSupplier"
                                            >
                                            </v-select>
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prod_price">Total Cost of Receipt</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" v-model="stock_entry_details.total_cost_of_receipt" name="total_cost_of_receipt" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right">
                                        <button type="button" @click="stockentry_addproduct" class="mb-xs mt-xs mr-xs btn btn-primary" title="Add Product"><i class="fa fa-plus"></i> ADD PRODUCT</button>                                  
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-nowrap" id="dt_se">
                                                <thead> <!-- ROW DETAILS DATATABLE -->
                                                    <tr style="text-align:center">
                                                        <th>Barcode No</th>
                                                        <th>Product</th>
                                                        <th>Expiry Date</th>
                                                        <th>Original Cost</th>
                                                        <th>Total Wholesale Cost</th>
                                                        <th>Selling Price</th>
                                                        <th>Markup</th>
                                                        <th>Discount</th>
                                                        <th>No of Stocks Added</th>
                                                        <th><i class="nav-icon fas fa-cog"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="se in stock_entry_list_details" :key="se.barcode_no" style="text-align:center">
                                                        <td>{{ se.barcode_no }}</td>
                                                        <td>{{ se.product_name }}</td>
                                                        <td>{{ se.expiry_date }}</td>
                                                        <td>{{ se.per_item_cost }}</td>
                                                        <td>{{ se.tot_whsale_cost }}</td>
                                                        <td>{{ se.selling_price }}</td>
                                                        <td>{{ se.markup }}</td>
                                                        <td>{{ se.discount }}</td>
                                                        <td>{{ se.stocks_added }}</td>
                                                        <td>
                                                            <a href="#" @click="editModal(se)">
                                                                <i class="fas fa-edit green"></i>
                                                            </a>
                                                            |
                                                            <a href="#" @click="deleteStockEntryProduct(se.barcode_no, se.product_name)">
                                                                <i class="fas fa-trash red"></i>
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
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button class="btn btn-block btn-success" @click="record_stock_entry" ><strong>RECORD STOCK ENTRY</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3">            
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">STOCK ENTRY LIST</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped text-nowrap" id="recent_stock_entry">
                            <thead>
                                <tr style="text-align:center">
                                    <th>Receipt No</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="se_rl in stock_entry_recent_list" :key="se_rl.stock_entry_no" style="text-align:center">
                                    <td>{{ se_rl.receipt_no }}</td>
                                    <td>{{ se_rl.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="stockentry_addproduct" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title">ADD PRODUCT</h5>
                        <h5 v-show="editmode" class="modal-title">EDIT PRODUCT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3"> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>
                                            <img class="product-image" v-if="product_details" :src="'/img/'+product_details.product_photo" alt="Product picture">
                                            <img class="product-image" v-else :src="'/img/product.png'" alt="Product picture" style="cursor:pointer;">  
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9"> 
                                <div class="row">                            
                                    <div class="col-md-5">
                                        <div class="form-group" v-show="!editmode">
                                            <label for="product">Product</label>
                                            <v-select 
                                                :reduce="product_options => product_options.barcode_no"
                                                placeholder="Select a Product"
                                                label="product_name" 
                                                :options="product_options"
                                                @input="selectedProduct"
                                            >
                                            </v-select>
                                        </div>  
                                        <div class="form-group" v-show="editmode">
                                            <label for="product">Product</label>                                        
                                            <v-select 
                                                v-model="stock_entry_selected_product_edit"
                                                :reduce="product_options => product_options.barcode_no"
                                                placeholder="Select a Product"
                                                label="product_name" 
                                                :options="product_options"
                                                @input="selectedProduct"
                                            >
                                            </v-select>
                                        </div>                                
                                    </div>
                                    <input type="hidden" v-model="markup_compute">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">Expiry date</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="date"  v-model="modal_details.expiry_date" name="expiry_date" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">No of Stocks Added</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" @keyup="trackChange" v-model="modal_details.stocks_added" name="stocks_added" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">Total Wholesale Cost</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" @keyup="trackChange" v-model="modal_details.tot_whsale_cost" name="tot_whsale_cost" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">Original Per Item Cost</label>
                                            <input type="text" v-model="per_item_compute" name="per_item_cost" class="form-control form-control-sm" disabled> 
                                            <!-- <p>{{ modal_details.tot_whsale_cost / modal_details.stocks_added }}</p>-->
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">Selling Price</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text" @keyup="trackChange" v-model="modal_details.selling_price" name="selling_price" value="0" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_product_sku">Discount (%)</label>
                                            <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                            <input type="text"  v-model="modal_details.discount" name="discount" value="0" class="form-control form-control-sm">
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-show="editmode" @click="se_editproduct" type="button" class="btn btn-success">Update </button>
                        <button v-show="!editmode" @click="se_addproduct" type="button" class="btn btn-primary">Add </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                editmode: true,
                modal_details: {
                    barcode_no: '',
                    product_name: '',
                    expiry_date: '',
                    per_item_cost: '0',
                    tot_whsale_cost: '0',
                    selling_price: '0',
                    markup: '0',
                    discount: '0',
                    stocks_added: '1',

                },
                product_details: [],
                product_options: [],
                supplier_options: [],
                stock_entry_details: {
                    stock_entry_no: '',
                    receipt_no: '',
                    selected_supplier: '',
                    total_cost_of_receipt: '',
                },
                stock_entry_list_details: [],
                stock_entry_selected_product_edit: '',
                stock_entry_recent_list: []
          }  
        },
        computed: {
            date_now: function() {
               return moment(Date.now()).format('MMMM Do YYYY, h:mm:ss a');
                 
            },
            sample_stock_entry_no: function(){
                this.stock_entry_details.stock_entry_no = Date.now();
                return Date.now();
            },
            per_item_compute: function() {
                let solve = this.modal_details.tot_whsale_cost / this.modal_details.stocks_added;
                this.modal_details.per_item_cost = solve; 
                return solve; 
            },
            markup_compute: function() {
                let markup = 0;
                markup = this.modal_details.selling_price - this.modal_details.per_item_cost;
                this.modal_details.markup = markup; 
                return markup;
            },
        },
        methods: {
            loadRecentStockEntry(){
                $("#recent_stock_entry").DataTable().destroy();
                axios.get("stockentry/get_recent_stock_entry").then(
                    ({ data }) => {
                        this.stock_entry_recent_list = data
                        this.forceRefreshSERECENTDataTable();
                    });
            },
            loadInformation(){
                const get_suppliers = axios.get("supplier/get_supplier_list_cmb");
                const get_products = axios.get("product/get_product_list");

                axios.all([get_suppliers, get_products]).then(axios.spread((...data) => {
                    this.supplier_options = data[0].data;
                    this.product_options = data[1].data;
                    // use/access the results 
                })).catch(errors => {
                // react on errors.
                });
                
            },
            selectedProduct(barcode_no){
                if(barcode_no == null){
                    barcode_no = 1000000;
                }
                axios.get("product/get_product_details/"+barcode_no).then(({ data }) => {
                    this.product_details = data[0]

                    if(typeof this.product_details !== "undefined"){
                        this.modal_details.barcode_no = this.product_details.barcode_no;
                        this.modal_details.product_name = this.product_details.product_name;
                    }
                });
            },
            selectedSupplier(supplier){
                this.stock_entry_details.selected_supplier = supplier;
            },
            stockentry_addproduct(){
                this.editmode = false;
                this.stock_entry_selected_product_edit = '';
                $('#stockentry_addproduct').modal('show')
            },
            editModal(se){
                this.editmode = true;

                this.modal_details.expiry_date = se.expiry_date;
                this.modal_details.stocks_added = se.stocks_added;
                this.modal_details.tot_whsale_cost = se.tot_whsale_cost;
                this.modal_details.per_item_cost = se.per_item_cost;
                this.modal_details.selling_price = se.selling_price;
                this.modal_details.discount = se.discount;

                this.stock_entry_selected_product_edit = se.barcode_no;
                this.selectedProduct(se.barcode_no);

                $('#stockentry_addproduct').modal('show');

            },
            se_addproduct(){
                const result = this.stock_entry_list_details.find( ({ barcode_no }) => barcode_no === this.product_details.barcode_no);
                
                if(result){
                    Toast2.fire({
                        icon: 'warning',
                        title: 'Product added already!'
                    })  
                }else{
                    this.stock_entry_list_details.push({ 
                        barcode_no: this.product_details.barcode_no,
                        product_name: this.product_details.product_name,
                        expiry_date: this.modal_details.expiry_date,
                        per_item_cost: this.modal_details.per_item_cost,
                        tot_whsale_cost: this.modal_details.tot_whsale_cost,
                        selling_price: this.modal_details.selling_price,
                        markup: this.modal_details.markup,
                        discount: this.modal_details.discount,
                        stocks_added: this.modal_details.stocks_added,
                    });
                    
                    $("#dt_se").DataTable().destroy();
                    this.forceRefreshSEDataTable();

                    this.modal_details.barcode_no = '';
                    this.modal_details.product_name = '';
                    this.modal_details.expiry_date = '';
                    this.modal_details.per_item_cost = '0';
                    this.modal_details.tot_whsale_cost = '0';
                    this.modal_details.selling_price = '0';
                    this.modal_details.markup = '0';
                    this.modal_details.discount = '0';
                    this.modal_details.stocks_added = '1';
                    
                    this.product_details = undefined;

                    $('#stockentry_addproduct').modal('hide')
                }
                
            },
            se_editproduct() {
                for (var se in this.stock_entry_list_details) {
                    if (this.stock_entry_list_details[se].barcode_no == this.product_details.barcode_no) {

                        this.stock_entry_list_details[se].barcode_no =this.product_details.barcode_no;
                        this.stock_entry_list_details[se].product_name =this.product_details.product_name;
                        this.stock_entry_list_details[se].expiry_date =this.modal_details.expiry_date;
                        this.stock_entry_list_details[se].per_item_cost =this.modal_details.per_item_cost;
                        this.stock_entry_list_details[se].tot_whsale_cost =this.modal_details.tot_whsale_cost;
                        this.stock_entry_list_details[se].selling_price =this.modal_details.selling_price;
                        this.stock_entry_list_details[se].markup =this.modal_details.markup;
                        this.stock_entry_list_details[se].discount =this.modal_details.discount;
                        this.stock_entry_list_details[se].stocks_added = this.modal_details.stocks_added;

                        break; //Stop this loop, we found it!
                    }
                }
                
                $("#dt_se").DataTable().destroy();
                this.forceRefreshSEDataTable();

                this.modal_details.barcode_no = '';
                this.modal_details.product_name = '';
                this.modal_details.expiry_date = '';
                this.modal_details.per_item_cost = '0';
                this.modal_details.tot_whsale_cost = '0';
                this.modal_details.selling_price = '0';
                this.modal_details.markup = '0';
                this.modal_details.discount = '0';
                this.modal_details.stocks_added = '1';
                
                this.product_details = undefined;

                $('#stockentry_addproduct').modal('hide')
            },
            trackChange() {
                this.modal_details.tot_whsale_cost = (this.modal_details.tot_whsale_cost === "" || this.modal_details.tot_whsale_cost === "0") ? 0 : this.modal_details.tot_whsale_cost;
                this.modal_details.stocks_added = (this.modal_details.stocks_added === "" || this.modal_details.stocks_added === "0") ? 1 : this.modal_details.stocks_added;
                this.modal_details.selling_price = (this.modal_details.selling_price === "" || this.modal_details.selling_price === "0") ? 1 : this.modal_details.selling_price;
            },
            forceRefreshSERECENTDataTable(){
                Vue.nextTick(function () {
                    $("#recent_stock_entry").DataTable({
                        "ordering": false,
                        "paging":   false,
                        "info":     false,
                        "searching": false 
                    }).draw();
                });
            },
            forceRefreshSEDataTable() {
                Vue.nextTick(function () {
                    $("#dt_se").DataTable({
                        "ordering": false,
                    }).draw();
                });
            },
            record_stock_entry() {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                 Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue recording the new stock entry",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();

                        var se_list_json = JSON.stringify(this.stock_entry_list_details);

                        let formData = new FormData();
                        formData.append('stock_entry_no', this.stock_entry_details.stock_entry_no);
                        formData.append('receipt_no', this.stock_entry_details.receipt_no);
                        formData.append('selected_supplier', this.stock_entry_details.selected_supplier);
                        formData.append('total_cost_of_receipt', this.stock_entry_details.total_cost_of_receipt);
                        formData.append('stock_entry_list_details', se_list_json);
                        
                        axios.post('stockentry', formData, config)
                        .then(()=>{   

                            Toast.fire({
                                icon: 'success',
                                title: 'Stock Entry Added Successfully!'
                            })  
                                                        
                            this.$Progress.finish();
                            
                            this.loadRecentStockEntry();
                            this.$router.go(0);

                        })
                        .catch(()=>{

                        })
                    }
                })

            } 
        },
        created() {
            this.loadInformation();
            this.loadRecentStockEntry();
            this.forceRefreshSEDataTable();
            this.selectedProduct(null);
        }
    }
</script>
