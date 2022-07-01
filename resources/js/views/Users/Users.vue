<template>
  <div class="table-responsive">
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
            }
        },
        mounted(){
          this.list()
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
                    this.users = data;
                }).catch(({ response })=>{
                    console.error(response)
                })
            },
            showMore(){              
              let x = this.pageCur + 1;

              this.list(this.pageCur, 6 * x);
            }
        }
    }
</script>

<style scoped>
    .pagination{
        margin-bottom: 0;
    }
</style>