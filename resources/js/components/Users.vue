<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Users Lists</h3>

                    <div class="card-tools">
                        <button class="btn btn-primary" @click="addNewModal">Add New User <i class="fas fa-user-plus fa-fw"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-nowrap">
                        <thead>
                            <tr style="text-align:center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Bio</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Registered</th>
                                <th><i class="nav-icon fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id" style="text-align:center">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.bio }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.type | toUppercase }}</td>
                                <td>{{ user.created_at | created_date }}</td> <!-- or <td>{{ new Date(user.created_at).toLocaleString() }}</td> -->                                
                                <td>
                                    <a href="#" @click="editModal(user)">
                                        <i class="fas fa-edit green"></i>
                                    </a>
                                    |
                                    <a href="#" @click="deleteUser(user.id)">
                                        <i class="fas fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnew" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="modalTitle">Add New Users</h5>
                        <h5 v-show="editmode" class="modal-title" id="modalTitle">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="form.email" type="text" name="email"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <input v-model="form.bio" type="text" name="bio" placeholder="Short description of User"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('bio') }">
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="bio">User type</label>
                                <select name="type" v-model="form.type" id="type" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('bio') }">
                                    <option value="">Select User Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="form.password" type="password" name="password"
                                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    bio: '',
                    type: '',
                    password: ''
                })
            }
        },
        methods: {
            addNewModal(){
                this.editmode = false;
                this.form.reset();
                $('#addnew').modal('show')

            },
            editModal(user){
                this.editmode = true;
                this.form.clear();
                this.form.reset();
                $('#addnew').modal('show')

                this.form.fill(user)
            },
            loadUsers(){
                this.$Progress.start();
                axios.get("api/user").then(
                    ({ data }) => (this.users = data.data)
                );
                this.$Progress.finish();
            },
            createUser(){
                Swal.fire({
                    title: 'Continue?',
                    text: "Would you like to continue adding user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                    }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();

                        this.form.post('api/user') // promises
                        .then(()=>{                            
                            Fire.$emit('AfterCreatingUpdatingDeletingUser'); // custom event
                            
                            $('#addnew').modal('hide')

                            Toast.fire({
                                icon: 'success',
                                title: 'User Created Successfully!'
                            })        
    
                            // this.loadUsers(); // load data again after create
                            this.$Progress.finish();
                            
                        })
                        .catch(()=>{

                        })

                    }
                })
            },
            updateUser(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue editing user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    
                    if (result.value) {
                        // send request to the server
                        this.form.put('api/user/'+this.form.id)
                        .then(()=>{
                            this.$Progress.start();

                            Fire.$emit('AfterCreatingUpdatingDeletingUser'); // custom event
                                    
                            $('#addnew').modal('hide')

                            Toast.fire({
                                icon: 'success',
                                title: 'User Info Edited Successfully!'
                            })  
                            
                            this.$Progress.finish();

                        })
                        .catch(()=>{
                            this.$Progress.fail();
                        });
                    }
                })
                
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue deleting user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {
                    
                    if (result.value) {
                        // send request to the server
                        this.form.delete('api/user/'+id)
                        .then(()=>{
                            Fire.$emit('AfterCreatingUpdatingDeletingUser');
                            Toast.fire({
                                icon: 'success',
                                title: 'User Deleted Successfully!'
                            })   
                        })
                        .catch(()=>{
                            Toast.fire({
                                icon: 'warning',
                                title: 'Something is wrong! User not deleted.'
                            })
                        })
                    }
                })
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreatingUpdatingDeletingUser', () => {
                this.loadUsers();
            }); // todo if custom event is encountered

            // setInterval(() => this.loadUsers(), 3000); // http request every 3 secs
            // LARAVEL ECHO => check if something is new in server then triggers an event to update data in all users 
        }
    }
</script>
