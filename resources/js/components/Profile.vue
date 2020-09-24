<template>
    <div class="container-fluid">
        <div class="row mt-3">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-success card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" v-if="photoURL" :src="photoURL" alt="User profile picture">
                  <img class="profile-user-img img-fluid img-circle" v-else :src="'../img/'+info.photo" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ info.name }}</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title mb-0">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="fas fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-success card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">

                    <!-- <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>

                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="fas fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div> -->
                                    
                  </div> 

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-md-10">
                          <input v-model="info.name" type="text" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input v-model="info.email" type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-md-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <label for="profileupload" class="col-sm-2 col-form-label">Profile Photo</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input @change="updateProfilePicture" type="file" class="file-input" id="profilephoto">
                                    <label class="custom-file-label" for="profilephoto" v-if="photoName"> {{ photoName }} </label>
                                    <label class="custom-file-label" for="profilephoto" v-else> {{ info.photo }} </label>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button @click.prevent="updateProfileInfo" type="submit" class="btn btn-primary">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                info: new Form({
                    id: '',
                    name: '',
                    email: '',
                    bio: '',
                    password: '',
                    photo: null
                }),
                photoURL: '',
                photoName: ''
            }
        },
        methods: {
            load() {
              axios.get('profiles/getinfo')
              .then(({ data }) => (this.info.fill(data)))
            },
            updateProfileInfo(){
               const config = {
                  headers: { 'content-type': 'multipart/form-data' }
               }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Would you like to continue editing your profile?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue'
                }).then((result) => {                    
                    if (result.value) {
                        this.$Progress.start();
                        // send request to the server
                        let formData = new FormData();
                        formData.append('name', this.info.name);
                        formData.append('email', this.info.email);
                        formData.append('photo', this.info.photo);

                        axios.post('profiles/'+this.info.id, formData, config)
                        .then(({data}) => {
                          if(Number(data) == 1) {
                            
                            Fire.$emit('AfterUpdateOfProfile'); // custom event
                                    
                            Toast.fire({
                                icon: 'success',
                                title: 'Profile Info Edited Successfully!'
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
            updateProfilePicture(e) {
                // this.picture = this.$refs.photofile.files; // file list
                const image = e.target.files[0];
                this.info.photo = image;
                this.photoName = image.name;
                this.photoURL = URL.createObjectURL(image);

                // or
                // let file = e.target.files[0];
                // let reader = new FileReader();
                // reader.onloadend = (file) => {
                //     console.log('RESULT', reader.result)
                //     this.info.photo = reader.result;
                // }
                // reader.readAsDataURL(file);
            }
        },
        created() {
            this.load();
            Fire.$on('AfterUpdateOfProfile', () => {
                this.load();
                window.location.reload()
            });
        }
    }
</script>
