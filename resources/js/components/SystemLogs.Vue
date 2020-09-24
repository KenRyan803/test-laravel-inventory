<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title mb-0">System Logs</h3>

                    <div class="card-tools">
                        <!-- <button class="btn btn-success" @click="addNewModal">Add New User <i class="fas fa-user-plus fa-fw"></i></button> -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dt">
                            <thead>
                                <tr style="text-align:center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>From</th>
                                    <th>Activity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="logs in systemlogs" :key="logs.id" style="text-align:center">
                                    <td>{{ logs.id }}</td>
                                    <td>{{ logs.name }}</td>
                                    <td>{{ logs.type | toUppercase }}</td>
                                    <td>{{ logs.from }}</td>
                                    <td>{{ logs.activity }}</td>
                                    <td>{{ logs.created_at | created_date }}</td> <!-- or <td>{{ new Date(user.created_at).toLocaleString() }}</td> -->                                
                                    
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                systemlogs: []
            }
        },
        methods: {            
            loadLogs(){
                this.$Progress.start();
                $("#dt").DataTable().destroy();

                axios.get("systemlog/getlogs").then(({ data }) => {
                    this.systemlogs = data
                    this.forceRefreshUserDataTable();
                    this.$Progress.finish();                    
                }).catch(() => {
                    swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        type: 'error'
                    })
                    this.$Progress.fail();
                })
            },
            forceRefreshUserDataTable() {
                Vue.nextTick(function () {
                    $("#dt").DataTable({"ordering": false,}).draw();
                });
            }
        },
        mounted() {
            this.loadLogs();
            console.log('Component mounted.')
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