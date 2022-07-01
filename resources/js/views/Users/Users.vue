<template>
  <div class="table-responsive">
      <div align="center">
        <h2>Create User</h2>
        <div class="mt-4"><input type="text" v-model="name" placeholder="Name" /></div>
        <div class="mt-4"><input type="text" v-model="email" placeholder="Email" /></div>
        <div class="mt-4"><input type="text" v-model="phone" placeholder="Phone" /></div>
        <div class="mt-2">
          <label>Select position</label><br/>
          <select v-model="selectedPosition">
            <option v-for="position in positionData" :value="position.id">{{position.name}}</option>
          </select>
        </div>
        <div class="btn btn-primary mt-3" @click="save">Create User</div>
      </div>  

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

      <div align="center" class="mt-3 text-primary" style="cursor: pointer" @click="showMore()"><u>Show more</u></div>
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
                pageCur: null,
                name: null,
                email: null,
                phone: null,
                selectedPosition: null,
                positionData: []
            }
        },
        mounted(){
          this.list();
          this.getPositions();
        },
        methods:{
            async list(page=1, count){  
                this.pageCur = page;            
                
                if(count){
                  page = page + 1;

                  this.pageCur = page;
                }                

                let url = `?`;
                if(count){
                  url += `&count=${count}`;
                } else {
                  url += `&page=${page}`;
                }

                await axios.get(`/api/users${url}`).then(({data})=>{
                    this.users = data.users;
                }).catch(({ response })=>{
                    console.error(response)
                })
            },
            showMore(){              
              let x = this.pageCur + 1;

              this.list(this.pageCur, 6 * x);
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
                     axios.post(`/api/token`).then(({data})=>{
                        if(data.token){
                          
                        }
                      }).catch(({ response })=>{
                          console.error(response)
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

    input, select{width: 400px}
</style>