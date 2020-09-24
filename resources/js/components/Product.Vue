<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mt-3">
                <div class="form-group">
                    <v-select 
                        :reduce="product_options => product_options.barcode_no"
                        placeholder="Select a product"
                        label="product_name" 
                        :options="product_options"
                        @input="selectedProduct"
                    >
                    </v-select>
                </div>
            </div>
            <div class="col-md-9 mt-3" style="text-align:right">
                <button type="button" @click="addnewproduct" class="mb-xs mt-xs mr-xs btn btn-primary" title="Add Product"><i class="fa fa-plus"></i> ADD NEW PRODUCT</button>
            </div>
        </div>
        <hr class="mt-0">
        <div class="row mt-3">
          <div class="col-md-3">
            <!-- Product Image -->
            <div class="card card-success card-outline">

              <div class="card-body box-profile" v-if="product_details">
                <div class="text-center">
                  <img class="product-image" :src="'img/'+product_details.product_photo" alt="Product Picture"> 
                </div>

                <h3 class="profile-username text-center mt-4"> {{ product_details.product_name }} </h3>
                <p class="text-muted text-center mb-0">{{ product_details.barcode_no }}</p>
              </div>

              <div class="card-body box-profile" v-else>
                <div class="text-center">
                  <img class="product-image" :src="'/img/product.png'" alt="Product picture">  
                </div>

                <h3 class="profile-username text-center mt-4"> PRODUCT NAME </h3>
                <p class="text-muted text-center mb-0">barcode here</p>
              </div>

            </div>
          </div>
          
          <div class="col-md-9">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title mb-0">PRODUCT INFORMATION</h3>

                    <div class="card-tools">
                        <button class="btn btn-warning" @click="editProductModal(product_details)"><i class="fas fa-edit fa-fw"></i> UPDATE PRODUCT</button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row" v-if="product_details">
                        <div class="col-md-12"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prod_desc">Product Description</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <textarea type="text" v-model="product_details.product_description" name="prod_desc" class="form-control form-control-sm" row="4"></textarea>
                                    </div>                                
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prod_cate">Product Category</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" v-model="product_details.category_name" name="prod_cate" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_unit">Product Unit</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" v-model="product_details.product_unit" name="prod_unit" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_unit">SKU <span style="font-style:italic">(if any)</span></label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" v-model="product_details.sku" name="prod_sku" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-else>
                        <div class="col-md-12"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prod_desc">Product Description</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <textarea type="text" name="prod_desc" class="form-control form-control-sm" row="4"></textarea>
                                    </div>                                
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prod_cate">Product Category</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_cate" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_unit">Product Unit</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_unit" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_unit">SKU <span style="font-style:italic">(if any)</span></label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_sku" class="form-control form-control-sm">
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title mb-0">PRODUCT ADDITIONAL INFORMATION | CURRENT STOCKS IN RETAIL</h3>
                </div>
                <div class="card-body">

                    <div class="row" v-if="product_info_latest_details"> 
                        <div class="col-md-12">  
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="prod_cost">Supplier</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input v-model="product_info_latest_details.supplier_name" type="text" name="prod_supplier" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_price">Expiry Date</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input v-model="product_info_latest_details.expiry_date" type="text" name="prod_expiry" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_cost">Cost</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input v-model="product_info_latest_details.original_price" type="text" name="prod_cost" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_price">Selling Price</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input v-model="product_info_latest_details.selling_price" type="text" name="prod_price" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_cost">No of stocks available</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input v-model="product_info_latest_details.stocks_added" type="text" name="prod_stocks" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-else> 
                        <div class="col-md-12">  
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="prod_cost">Supplier</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_supplier" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_price">Expiry Date</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_expiry" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_cost">Cost</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_cost" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_price">Selling Price</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_price" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prod_cost">No of stocks available</label>
                                        <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                        <input type="text" name="prod_stocks" class="form-control form-control-sm" disabled>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title mb-0">PRODUCT INFORMATION LOGS</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0"> 
                        <table class="table table-striped" id="dt_pi">
                            <thead>
                                <tr style="text-align:center">
                                    <th>Stock Entry No</th>
                                    <th>Original Price</th>
                                    <th>Selling Price</th>
                                    <th>Markup</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th><i class="nav-icon fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pi in product_info_list" :key="pi.id" style="text-align:center">
                                    <td>{{ pi.stock_entry_no }}</td>
                                    <td>{{ pi.original_price }}</td>
                                    <td>{{ pi.selling_price }}</td>
                                    <td>{{ pi.markup_price_php }}</td>
                                    <td>{{ pi.discount_php }}</td>
                                    <td>{{ pi.status }}</td>
                                    <td>{{ pi.created_at | created_date }}</td>
                                    <td>
                                        <a href="#" @click="edit_status(pi)">
                                            <i class="fas fa-edit green"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>


        <div class="modal" tabindex="-1" id="addnewproduct" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title">ADD NEW PRODUCT</h5>
                        <h5 v-show="editmode" class="modal-title">EDIT PRODUCT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? editProduct() : addProduct()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3"> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <img class="product-image" v-if="new_product_picture_URL" :src="new_product_picture_URL" alt="Product picture" style="cursor:pointer;"> 
                                                <img class="product-image" v-else-if="selected_category" :src="'/img/'+add_form.add_product_photo" alt="Product picture" style="cursor:pointer;">  <!-- to refrain program from emitting error of img undefined, cannot use editmode so selected_category is used -->
                                                <img class="product-image" v-else :src="'/img/product.png'" alt="Product picture" style="cursor:pointer;">  
                                                <input type="file" @change="newProductPicture" name="add_prod_picture" id="add_prod_picture" style="display:none">                             
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9"> 
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="add_product_barcode">Barcode</label>
                                                <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                                <input type="text" name="add_product_barcode" class="form-control form-control-sm"
                                                    v-model="add_form.add_product_barcode" :class="{ 'is-invalid': add_form.errors.has('add_product_barcode') }">
                                                <has-error :form="add_form" field="add_product_barcode"></has-error>
                                            </div>                                
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="add_product_name">Product Name</label>
                                                <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                                <input type="text" name="add_product_name" class="form-control form-control-sm"
                                                    v-model="add_form.add_product_name" :class="{ 'is-invalid': add_form.errors.has('add_product_name') }">
                                                <has-error :form="add_form" field="add_product_name"></has-error>
                                            </div>                                
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="add_product_description">Product Description</label>
                                                <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                                <textarea type="text" name="add_product_description" class="form-control form-control-sm" row="4"
                                                    v-model="add_form.add_product_description"></textarea>
                                            </div>                                
                                        </div>
                                    </div>
                                    <div class="row">                            
                                        <div class="col-md-4">
                                            <div class="form-group" v-show="!editmode">
                                                <label for="add_product_category">Product Category</label>
                                                <v-select 
                                                    :reduce="product_category_options => product_category_options.category_no"
                                                    placeholder="Select a Product Category"
                                                    label="category_name" 
                                                    :options="product_category_options"
                                                    @input="selectedProductCategory"
                                                >
                                                </v-select>
                                            </div>  
                                            <div class="form-group" v-show="editmode">
                                                <label for="add_product_category">Product Category</label>
                                                <v-select 
                                                    v-model="selected_category"
                                                    :reduce="product_category_options => product_category_options.category_no"
                                                    placeholder="Select a Product Category"
                                                    label="category_name" 
                                                    :options="product_category_options"
                                                    @input="selectedProductCategory"
                                                >
                                                </v-select>
                                            </div>                                
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="add_product_unit">Product Unit</label>
                                                <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                                <input type="text" name="add_product_unit" class="form-control form-control-sm"
                                                    v-model="add_form.add_product_unit" :class="{ 'is-invalid': add_form.errors.has('add_product_unit') }">
                                                <has-error :form="add_form" field="add_product_unit"></has-error>
                                            </div>                                
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="add_product_sku">SKU <span style="font-style:italic">(if any)</span></label>
                                                <!-- <input v-model="form.name" type="text" name="name" class="form-control"> -->
                                                <input type="text" name="add_product_sku" class="form-control form-control-sm"
                                                    v-model="add_form.add_product_sku">
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editstatusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title" id="modalTitle">Change status for pricing</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Stock Entry No</label>
                            <input v-model="edit_status_product_info.stock_entry_no" type="text" name="category_name" class="form-control form-control-sm" disabled> 
                        </div>   
                        <div class="form-group">
                            <label for="name">Current Pricing</label>
                            <input v-model="edit_status_product_info.original_price" type="text" name="category_name" class="form-control form-control-sm" disabled>
                        </div>  
                        <div class="form-group">
                            <label for="name">Price to be changed</label>
                            <input v-model="edit_status_product_info.selling_price" type="text" name="category_name" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Activate Pricing</label>
                            <input type="text" name="category_name" class="form-control" value="ACTIVATED" disabled v-if="edit_status_product_info.status == 1">
                            <v-select v-else
                                :reduce="status_changed => status_changed.status"
                                placeholder="Select status"
                                label="status_name" 
                                :options="status_changed"
                                @input="selectedStatus"

                            >
                            </v-select>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button v-if="edit_status_product_info.status == 1" type="submit" class="btn btn-success btn-sm" disabled>Update </button>
                        <button v-else @click="editStatusForPricing" type="submit" class="btn btn-success btn-sm">Update </button>
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
                editmode: true,
                product_details: [],
                product_options: [],
                product_info_list: [],
                product_category_options: [],
                add_form: new Form({
                    id: '',
                    add_product_barcode: '',
                    add_product_name: '',
                    add_product_description: '',
                    add_product_category: '',
                    add_product_unit: '',
                    add_product_sku: '',
                    add_product_photo: '',
                }),
                new_product_picture_name: '',
                new_product_picture_URL: '',
                selected_category: '',
                status_changed: [{
                    status: '1',
                    status_name: 'Activate'
                }],
                selected_status: '',
                product_info_latest_details: [],
                edit_status_product_info: {
                    product_info_id: '',
                    barcode_no: '',
                    stock_entry_no: '',
                    original_price: '',
                    selling_price: '',
                    status: '',
                }, 
          }  
        },
        methods: {
            loadInformation(){
                const get_product_category = axios.get("product_category/get_category");
                const get_products = axios.get("product/get_product_list");

                axios.all([get_product_category, get_products]).then(axios.spread((...data) => {
                    this.product_category_options = data[0].data;
                    this.product_options = data[1].data;
                    // use/access the results 
                })).catch(errors => {
                // react on errors.
                });
            },
            addnewproduct(){
                this.editmode = false;
                this.add_form.reset();
                this.selected_category = '';
                $('#addnewproduct').modal('show')

            },
            editProductModal(product_details){
                if(product_details != undefined){
                    this.editmode = true;
                    this.add_form.clear();
                    this.add_form.reset();
                    $('#addnewproduct').modal('show')
                    
                    this.add_form.id = product_details.id;
                    this.add_form.add_product_barcode = product_details.barcode_no;
                    this.add_form.add_product_name =product_details.product_name;
                    this.add_form.add_product_description = product_details.product_description;
                    this.add_form.add_product_sku = product_details.sku;
                    this.add_form.add_product_unit = product_details.product_unit;
                    this.add_form.add_product_photo = product_details.product_photo;

                    this.selected_category = product_details.category_no;
                    
                    this.selectedProductCategory(product_details.category_no);
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'SELECT A PRODUCT FIRST!'
                    })  
                }
                
            },
            newProductPicture(e) {
                const image = e.target.files[0];
                this.add_form.add_product_photo = image;
                this.new_product_picture_name = image.name;
                this.new_product_picture_URL = URL.createObjectURL(image);

            },
            selectedProduct(barcode_no){
                if(barcode_no == null){
                    barcode_no = 1000000;
                }
                
                const get_product_details = axios.get("product/get_product_details/"+barcode_no);
                const get_product_info_list = axios.get("product/get_product_info_list/"+barcode_no);
                const get_product_info_latest_details = axios.get("product/get_product_info_latest_details/"+barcode_no);
                
                $("#dt_pi").DataTable().destroy();
                axios.all([get_product_details, get_product_info_list, get_product_info_latest_details]).then(axios.spread((...data) => {
                    this.product_details = data[0].data[0];
                    this.product_info_list = data[1].data;
                    this.product_info_latest_details = data[2].data[0];
                                  
                    this.forceRefreshPIDataTable();
                })).catch(errors => {
                // react on errors.
                });

            },
            selectedProductCategory(product_category){
                this.add_form.add_product_category = product_category;
                // this.selected_category = '';
            },
            selectedStatus(stat){
                this.selected_status = stat;
            },
            addProduct(){
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue adding a new product?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();

                        let formData = new FormData();
                        formData.append('barcode_no', this.add_form.add_product_barcode);
                        formData.append('sku', this.add_form.add_product_sku);
                        formData.append('category_no', this.add_form.add_product_category);
                        formData.append('product_name', this.add_form.add_product_name);
                        formData.append('product_unit', this.add_form.add_product_unit);
                        formData.append('product_description', this.add_form.add_product_description);
                        formData.append('product_photo', this.add_form.add_product_photo);
                        
                        axios.post('product', formData, config)
                        .then(()=>{                                 
                            Fire.$emit('AfterCreatingUpdatingDeletingProduct');                                 
                            $('#addnewproduct').modal('hide')

                            Toast.fire({
                                icon: 'success',
                                title: 'New Product Added Successfully!'
                            })  
                                                        
                            this.$Progress.finish();                      
                                                            
                        })
                        .catch(()=>{

                        })

                    }
                })
            },
            editProduct(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue editing the product?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {                    
                    if (result.value) {
                        this.$Progress.start();
                        // send request to the server
                        axios({
                            method: 'put', 
                            url: 'product/'+this.add_form.id,
                            data: {
                                barcode_no: this.add_form.add_product_barcode,
                                sku: this.add_form.add_product_sku,
                                category_no: this.add_form.add_product_category,
                                product_name: this.add_form.add_product_name,
                                product_unit: this.add_form.add_product_unit,
                                product_description: this.add_form.add_product_description,
                                product_photo: this.add_form.add_product_photo,
                            }
                        }).then(({data})=>{
                            if(Number(data) == 1) {
                                Fire.$emit('AfterCreatingUpdatingDeletingProduct'); // custom event                                                               
                                $('#addnewproduct').modal('hide')

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Product Edited Successfully!'
                                })  
                                
                                this.selectedProduct(this.add_form.add_product_barcode);
                                this.$Progress.finish();
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
            edit_status(pi){
                this.edit_status_product_info.product_info_id = pi.id;
                this.edit_status_product_info.barcode_no = pi.barcode_no;
                this.edit_status_product_info.stock_entry_no = pi.stock_entry_no;
                this.edit_status_product_info.original_price = pi.original_price;
                this.edit_status_product_info.selling_price = pi.selling_price;
                this.edit_status_product_info.status = pi.status;

                $('#editstatusmodal').modal('show')
            },
            editStatusForPricing(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to change status and use this pricing for this product?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {                    
                    if (result.value) {
                        this.$Progress.start();
                        // send request to the server
                        axios({
                            method: 'post', 
                            url: 'product/update_status',
                            data: {
                                product_info_id: this.edit_status_product_info.product_info_id,
                                // barcode_no: this.edit_status_product_info.barcode_no,
                                // stock_entry_no: this.edit_status_product_info.stock_entry_no,
                                selected_status: this.selected_status,
                            }
                        }).then(({data})=>{
                            if(Number(data) == 1) {  
                                $('#editstatusmodal').modal('hide')

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Product Edited Successfully!'
                                })

                                this.selectedProduct(this.edit_status_product_info.barcode_no);
                                this.$Progress.finish();
                                
                            }else{
                                Toast.fire({
                                    icon: 'warning',
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
            forceRefreshPIDataTable() {
                Vue.nextTick(function () {
                    $("#dt_pi").DataTable({"ordering": false,}).draw();
                });
            },
        },
        created() {
            this.loadInformation();
            this.selectedProduct(null);
            Fire.$on('AfterCreatingUpdatingDeletingProduct', () => {
                this.loadInformation();
            }); 
        }
    }
</script>
