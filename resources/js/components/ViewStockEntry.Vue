<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 mt-3">
                <div class="form-group">
                    <v-select 
                        :reduce="stock_entry_cmb => stock_entry_cmb.stock_entry_no"
                        placeholder="Select Stock Entry"
                        label="stock_with_date" 
                        :options="stock_entry_cmb"
                        @input="selected_stock_entry"
                    >
                    </v-select>
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">STOCK ENTRY DETAILS</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Stock Entry No</b> <a class="float-right">{{ stock_entry_details.stock_entry_no }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Receipt No</b> <a class="float-right">{{ stock_entry_details.receipt_no }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Supplier</b> <a class="float-right">{{ stock_entry_details.supplier_name }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Products Added</b> <a class="float-right">{{ stock_entry_details.total_products_added }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Stocks Added</b> <a class="float-right">{{ stock_entry_details.total_stocks_added }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Cost of Receipt</b> <a class="float-right">{{ stock_entry_details.total_cost_of_receipt }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Created</b> <a class="float-right">{{ stock_entry_details.created_at | created_date }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">STOCK ENTRY LIST</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap" id="dt_se_list">
                                <thead>
                                    <tr style="text-align:center">
                                        <th>Barcode No</th>
                                        <th>Product Name</th>
                                        <th>Expiry Date</th>
                                        <th>Original Cost Per Item</th>
                                        <th>Total Wholesale Cost</th>
                                        <th>Stocks Added</th>
                                        <th><i class="nav-icon fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="se_list in stock_entry_list" :key="se_list.stock_entry_no" style="text-align:center">
                                        <td>{{ se_list.barcode_no }}</td>
                                        <td>{{ se_list.product_name }}</td>
                                        <td>{{ se_list.expiry_date }}</td>
                                        <td>{{ se_list.orig_cost_per }}</td>
                                        <td>{{ se_list.total_whlsale_cost }}</td>
                                        <td>{{ se_list.stocks_added }}</td>
                                        <td> 
                                            <a href="#" @click="info_of_product_in_this_inventory(se_list)">
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

        <!-- <div class="modal" tabindex="-1" id="stockentry_addproduct" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ADD PRODUCT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="add_product_sku">Expiry date</label>
                                    <input type="date" name="expiry_date" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
</template>

<script>
    export default {
        data(){
            return{
                stock_entry_cmb: [],
                stock_entry_details: [],
                stock_entry_list: [],
            }
        },
        methods: {
            loadStockEntry(){
                $("#dt_se_list").DataTable().destroy();
                axios.get("view_stockentry/get_stock_entry").then(
                    ({ data }) => {
                        this.stock_entry_cmb = data
                        this.forceRefreshSELISTDataTable();
                    });
            },
            info_of_product_in_this_inventory(se_list){
                
            },
            selected_stock_entry(stock_entry_no){
                if(stock_entry_no == null){
                    stock_entry_no = "10000000";
                }
                                
                $("#dt_se_list").DataTable().destroy();

                const get_stock_entry_details = axios.get("view_stockentry/get_stock_entry_details/"+stock_entry_no);
                const get_stock_entry_list = axios.get("view_stockentry/get_stock_entry_list/"+stock_entry_no);
                
                $("#dt_pi").DataTable().destroy();
                axios.all([get_stock_entry_details, get_stock_entry_list]).then(axios.spread((...data) => {
                    this.stock_entry_details = data[0].data[0];
                    this.stock_entry_list = data[1].data;
                                  
                    this.forceRefreshSELISTDataTable();
                })).catch(errors => {
                // react on errors.
                });
                
            },
            forceRefreshSELISTDataTable() {
                Vue.nextTick(function () {
                    $("#dt_se_list").DataTable({"ordering": false,}).draw();
                });
            },
        },
        created() {
            this.loadStockEntry();
            console.log('Component mounted.')
        }
    }
</script>
