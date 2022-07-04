<template>
  <div class="table-responsive">
      <form class="m-5">
        <h2>Create User</h2>
        
        <div v-if="errors" class="bg-red-500 text-danger py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
          <div v-for="(v, k) in errors" :key="k">
            <p v-for="error in v" :key="error" class="text-sm">
              {{ error }}
            </p>
          </div>
        </div>

        <div class="form-group mt-2">
          <input type="text" class="form-control form-control-lg" v-model="name" placeholder="Name" />
        </div>
        <div class="form-group mt-2">
          <input type="text" class="form-control form-control-lg"  v-model="email" placeholder="Email" />
        </div>
        <div class="form-group mt-2">
          <input type="text" class="form-control form-control-lg" v-model="phone" placeholder="Phone" />
        </div>
        <div class="form-group mt-2">
          <select class="form-control form-control-lg" v-model="selectedPosition">
            <option value="0" disabled selected>Select position</option>
            <option v-for="position in positionData" :value="position.id">{{position.name}}</option>
          </select>
        </div>
        <div class="form-group mt-2">
          <label for="photo">Photo</label>
          <input type="file" ref="photo" class="form-control-file" id="photo">
        </div>
        <div class="btn btn-primary mt-3" @click="save">Create User</div>
      </form>  

      <h2 align="center" class="mt-5">Users</h2>
      <table class="table table-bordered text-center">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Position</th>
                  <th>Position ID</th>
                  <th>Registration Timestamp</th>
                  <th>Photo</th>
              </tr>
          </thead>
          <tbody v-if="users && users.data.length > 0">
              <tr v-for="(user,index) in users.data" :key="index">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.phone }}</td>
                  <td>{{ user.position.name }}</td>
                  <td>{{ user.position_id }}</td>
                  <td>{{ user.registration_timestamp }}</td>
                  <td><img :src="user.photo_url" alt="user" width="70" /></td>
              </tr>
          </tbody>
          <tbody v-else>
              <tr>
                  <td align="center" colspan="3">No record found.</td>
              </tr>
          </tbody>
      </table>
      <Pagination class="mt-3" align="center" :data="users" @pagination-change-page="list"></Pagination>
  </div>
</template>

<script>
    import LaravelVuePagination from 'laravel-vue-pagination';

    export default {
        name:"Users",
        components:{
            'Pagination': LaravelVuePagination
        },
        data(){
            return {
                users: {
                  type:Object,
                  default:null
                },
                name: null,
                email: null,
                phone: null,
                photo: null,
                selectedPosition: 0,
                positionData: [],
                errors: null,
            }
        },
        mounted(){
          this.list();
          this.getPositions();
        },
        methods:{
            async list(page=1){                  
                await axios.get(`/api/users?page=${page}&count=6`).then(({data})=>{
                    this.users = data.users;
                }).catch(({ response })=>{
                    console.error(response)
                })
            },
            getPositions(){
              axios.get(`/api/positions`).then(({data})=>{
                  this.positionData = data.positions;
              }).catch(({ response })=>{
                  console.error(response)
              })
            },
            save(){
              axios.get(`/api/token`).then(({data})=>{
                  if(data.token){

                    let user = new FormData();

                    user.append('name', this.name);
                    user.append('email', this.email);
                    user.append('phone', this.phone);
                    user.append('position_id', this.selectedPosition);
                    user.append('photo', this.$refs.photo.files[0]);

                    axios.post(
                      `/api/users`, 
                      user,
                      { headers:{'Token' : data.token}}
                    ).then(({data})=>{
                      alert(data.message);
                      
                      location.reload();
                    }).catch(({ response })=>{
                      this.errors = response.data.fails;
                    })       
                  }
              }).catch(({ response })=>{
                  console.error(response)
              })
            }
        }
    }
</script>

<style scoped>
    .pagination{
        margin-bottom: 0;
    }
</style>