<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Product Category Lists</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="addNewModal"><i class="fas fa-plus fa-fw"></i> Add Product Category</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap" id="dt_pc">
                                <thead>
                                    <tr style="text-align:center">
                                        <th>Category No</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th>Created</th>
                                        <th><i class="nav-icon fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="pc in product_category" :key="pc.category_no" style="text-align:center">
                                        <td>{{ pc.category_no }}</td>
                                        <td>{{ pc.category_name }}</td>
                                        <td>{{ pc.category_description }}</td>
                                        <td>{{ pc.created_at | created_date }}</td> <!-- or <td>{{ new Date(user.created_at).toLocaleString() }}</td> -->                                
                                        <td>
                                            <a href="#" @click="editModal(pc)">
                                                <i class="fas fa-edit green"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteProductCategory(pc.category_no, pc.category_name)">
                                                <i class="fas fa-trash red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="modal fade" id="addnewproductcategpry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="modalTitle">Add Product Category</h5>
                        <h5 v-show="editmode" class="modal-title" id="modalTitle">Edit Product Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateProductCategory() : createProductCategory()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input v-model="form.category_name" type="text" name="category_name"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('category_name') }">
                                <has-error :form="form" field="category_name"></has-error>
                            </div>                            
                            <div class="form-group">
                                <label for="name">Category Description</label>
                                <textarea v-model="form.category_description" type="text" name="category_description"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('category_description') }"></textarea>
                                <has-error :form="form" field="category_description"></has-error>
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success btn-sm">Update </button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary btn-sm">Create </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                editmode: true,
                product_category: [],
                form: new Form({
                    category_no: '',
                    category_name: '',
                    category_description: '',
                })
            }
        },
        methods: {
            addNewModal(){
                this.editmode = false;
                this.form.reset();
                $('#addnewproductcategpry').modal('show')

            },
            editModal(pc){
                this.editmode = true;
                this.form.clear();
                this.form.reset();
                $('#addnewproductcategpry').modal('show')

                this.form.fill(pc)
            },
            loadProductCategory(){
                this.$Progress.start();
                $("#dt_pc").DataTable().destroy();
                axios.get("product_category/get_category").then(
                    ({ data }) => {
                        this.product_category = data                    
                        this.forceRefreshPCDataTable();
                        this.$Progress.finish();
                    });
            },
            createProductCategory(){
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue adding a product category?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    if (result.value) {                
                        this.$Progress.start();

                        let formData = new FormData();
                        formData.append('category_no', this.form.category_no);
                        formData.append('category_name', this.form.category_name);
                        formData.append('category_description', this.form.category_description);
                        
                        axios.post('product_category', formData, config)
                        .then(()=>{                                 
                            Fire.$emit('AfterCreatingUpdatingDeletingProductCategory');                                 
                            $('#addnewproductcategpry').modal('hide')

                            Toast.fire({
                                icon: 'success',
                                title: 'Product Category Created Successfully!'
                            })  
                                                        
                            this.$Progress.finish();                      
                                                            
                        })
                        .catch(()=>{

                        })

                    }
                })
            },
            updateProductCategory(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue editing product category?",
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
                            url: 'product_category/'+this.form.category_no,
                            data: {
                                category_name: this.form.category_name,
                                category_description: this.form.category_description,
                            }
                        }).then(({data})=>{
                            if(Number(data) == 1) {
                                Fire.$emit('AfterCreatingUpdatingDeletingProductCategory'); // custom event                                                               
                                $('#addnewproductcategpry').modal('hide')

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Product Category Edited Successfully!'
                                })  
                                
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
            deleteProductCategory(category_no, category_name){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue deleting product category?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    
                    if (result.value) {                        
                        axios({
                            method: 'delete',
                            url: 'product_category/'+category_no,
                            data: {
                                category_name: category_name
                            }
                        }).then(()=>{
                            Fire.$emit('AfterCreatingUpdatingDeletingProductCategory');
                            Toast.fire({
                                icon: 'success',
                                title: 'Product Category Deleted Successfully!'
                            })   
                        })
                        .catch(()=>{
                            Toast.fire({
                                icon: 'warning',
                                title: 'Something is wrong! Product Category not deleted.'
                            })
                        })
                    }
                })
            },
            forceRefreshPCDataTable() {
                Vue.nextTick(function () {
                    $("#dt_pc").DataTable({"ordering": false,}).draw();
                });
            }
        },
        created() {
            this.loadProductCategory();
            Fire.$on('AfterCreatingUpdatingDeletingProductCategory', () => {
                this.loadProductCategory();
            }); 
        }
    }
</script>

<style scoped>
@import "~datatables.net-bs4/css/dataTables.bootstrap4.min.css";
.status_tag {
    background: red;
    color: white;
    padding: 4px;
    font-size: 0.7em;
}
.status_tag.yes {
    background: #2fa360;
    color: white;
    padding: 4px;
    font-size: 0.7em;
}

</style>