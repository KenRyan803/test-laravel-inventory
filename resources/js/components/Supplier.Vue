<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Supplier Lists</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="addNewModal"><i class="fas fa-plus fa-fw"></i> Add Supplier</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap" id="dt_supplier">
                                <thead>
                                    <tr style="text-align:center">
                                        <th>Supplier ID</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier Address</th>
                                        <th>Created</th>
                                        <th><i class="nav-icon fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sup in supplier_list" :key="sup.supplier_id" style="text-align:center">
                                        <td>{{ sup.supplier_id }}</td>
                                        <td>{{ sup.supplier_name }}</td>
                                        <td>{{ sup.supplier_address }}</td>
                                        <td>{{ sup.created_at | created_date }}</td> <!-- or <td>{{ new Date(user.created_at).toLocaleString() }}</td> -->                                
                                        <td>
                                            <a href="#" @click="editModal(sup)">
                                                <i class="fas fa-edit green"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteSupplier(sup.supplier_id, sup.supplier_name)">
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

        <div class="modal fade" id="addnewsupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="modalTitle">Add Supplier</h5>
                        <h5 v-show="editmode" class="modal-title" id="modalTitle">Edit Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateSupplier() : createSupplier()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input v-model="form.supplier_name" type="text" name="supplier_name"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('supplier_name') }">
                                <has-error :form="form" field="supplier_name"></has-error>
                            </div>                            
                            <div class="form-group">
                                <label for="supplier_address">Supplier Address</label>
                                <textarea v-model="form.supplier_address" type="text" name="supplier_address"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('supplier_address') }"></textarea>
                                <has-error :form="form" field="supplier_address"></has-error>
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
                supplier_list: [],
                form: new Form({
                    supplier_id: '',
                    supplier_name: '',
                    supplier_address: '',
                })
            }
        },
        methods: {
            addNewModal(){
                this.editmode = false;
                this.form.reset();
                $('#addnewsupplier').modal('show')

            },
            editModal(pc){
                this.editmode = true;
                this.form.clear();
                this.form.reset();
                $('#addnewsupplier').modal('show')

                this.form.fill(pc)
            },
            loadSupplier(){
                this.$Progress.start();
                $("#dt_supplier").DataTable().destroy();
                axios.get("supplier/get_supplier_list").then(
                    ({ data }) => {
                        this.supplier_list = data
                        this.forceRefreshSupplierDataTable();
                        this.$Progress.finish();
                    });
            },
            createSupplier(){
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue adding a supplier?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    if (result.value) {                
                        this.$Progress.start();

                        let formData = new FormData();
                        formData.append('supplier_id', this.form.supplier_id);
                        formData.append('supplier_name', this.form.supplier_name);
                        formData.append('supplier_address', this.form.supplier_address);
                        
                        axios.post('supplier', formData, config)
                        .then(()=>{                                 
                            Fire.$emit('AfterCreatingUpdatingDeletingSupplier');                
                            $('#addnewsupplier').modal('hide')

                            Toast.fire({
                                icon: 'success',
                                title: 'Supplier Created Successfully!'
                            })  
                                                        
                            this.$Progress.finish();                      
                                                            
                        })
                        .catch(()=>{

                        })

                    }
                })
            },
            updateSupplier(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue editing supplier?",
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
                            url: 'supplier/'+this.form.supplier_id,
                            data: {
                                supplier_name: this.form.supplier_name,
                                supplier_address: this.form.supplier_address,
                            }
                        }).then(({data})=>{
                            if(Number(data) == 1) {
                                Fire.$emit('AfterCreatingUpdatingDeletingSupplier'); // custom event                               
                                $('#addnewsupplier').modal('hide')

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Supplier Edited Successfully!'
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
            deleteSupplier(supplier_id, supplier_name){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue deleting supplier?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    
                    if (result.value) {                        
                        axios({
                            method: 'delete',
                            url: 'supplier/'+supplier_id,
                            data: {
                                supplier_name: supplier_name
                            }
                        }).then(()=>{
                            Fire.$emit('AfterCreatingUpdatingDeletingSupplier');
                            Toast.fire({
                                icon: 'success',
                                title: 'Supplier Deleted Successfully!'
                            })   
                        })
                        .catch(()=>{
                            Toast.fire({
                                icon: 'warning',
                                title: 'Something is wrong! Supplier not deleted.'
                            })
                        })
                    }
                })
            },
            forceRefreshSupplierDataTable() {
                Vue.nextTick(function () {
                    $("#dt_supplier").DataTable({"ordering": false,}).draw();
                });
            }
        },
        created() {
            this.loadSupplier();
            Fire.$on('AfterCreatingUpdatingDeletingSupplier', () => {
                this.loadSupplier();
            }); 
        }
    }
</script>
