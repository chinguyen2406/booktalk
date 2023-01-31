<template>
  <div class="top-right links" style="float: right;" >
    <!--UNLOGGED-->
    <span v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
        <a-button type="primary" class="login">
          <router-link  :to="{ name : route.path }" :key="key">
            {{route.name}}
          </router-link>
        </a-button>
    </span>
    <!--LOGGED USER-->
    <span v-if="$auth.check(1)" v-for="(route, key) in routes.user" v-bind:key="route.path">
        <a-button type="primary" class="dropdown">
            {{auth.name}}
            <div class="dropdown-content">
                  <router-link  :to="{ name : route.path }" :key="key" class="link">
                    {{route.name}}
                  </router-link>
                  <router-link  :to="{ name : 'profile' }" :key="key" class="link">
                    Cài đặt tài khoản
                  </router-link>
                  <router-link  :to="{ name : 'store' }" :key="key" class="link">
                    Kho lưu trữ cá nhân
                  </router-link>
            </div>
        </a-button>
    </span>
    <!--LOGGED ADMIN-->
    <span v-if="$auth.check(2)" v-for="(route, key) in routes.admin" v-bind:key="route.path">
        <a-button type="primary">
          <router-link  :to="{ name : route.path }" :key="key">
            {{route.name}}
          </router-link>
        </a-button>
    </span>
      <!--LOGGED supper ADMIN-->
      <span v-if="$auth.check(3)" v-for="(route, key) in routes.superAdmin" v-bind:key="route.path">
        <a-button type="primary">
          <router-link  :to="{ name : route.path }" :key="key">
            {{route.name}}
          </router-link>
        </a-button>
    </span>
    <!--LOGOUT-->
    <span v-if="$auth.check()">
            <a-button type="primary" icon="poweroff"  @click="logout()">
              Logout
            </a-button>
    </span>
  </div>
</template>

<script>
    import EventBus from '../app';
    import Login from '../pages/Login';

  export default {
    data() {
      return {
          auth: {},
        routes: {
          // UNLOGGED
          unlogged: [
            {
              name: 'Register',
              path: 'register'
            },
            {
              name: 'Login',
              path: 'login'
            }
          ],

          // LOGGED USER
          user: [
            {
              name: 'Home',
              path: 'home-user'
            }
          ],
          // LOGGED ADMIN
          admin: [
            {
              name: 'Home',
              path: 'admin.dashboard'
            }
          ],
            // LOGGED ADMIN
            superAdmin: [
                {
                    name: 'Home',
                    path: 'superAdmin.dashboard'
                }
            ]
        }
      }
    },

      created() {
          axios.get('/user')
              .then(response => {
                      this.auth = response.data;

                      console.log(this.user);
              })
              .catch(function (error) {
                  console.log(error);
              });

          EventBus.$on(Login.LOGIN, () => {
              axios.get('/user')
                  .then(response => {
                      this.auth = response.data;

                      console.log(this.user);
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
          });
      },

      methods: {
      logout() {
        this.$auth.logout()
        localStorage.removeItem('user_token');
      }
    }

  }
</script>

<style lang="scss" scoped>

  html, body {
    background-color: #ddd;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    margin: 0;
  }

  .dropdown {
      position: relative;
      display: inline-block;
  }

  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
  }

  .dropdown-content .link {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
  }

  .dropdown-content .link:hover {background-color: #f1f1f1}

  .dropdown:hover .dropdown-content {
      display: block;
  }

  .dropdown:hover .dropbtn {
      background-color: #3e8e41;
  }


  .login {
      margin-right: 10px;
  }
  .top_bar{
    position:relative; width:99%; top:0; padding:5px; margin:0 5
  }
  .full-height {
    margin-top:50px
  }
  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }
  .position-ref {
    position: relative;
  }
  .top-right {
    position: absolute;
    right:5px; top:15px
  }
  .top-left {
    position: absolute;
    left: 200px;
    width:20%
  }
  .content {
    text-align: center;
  }
  .title {
    font-size: 84px;
  }
  .links>span>a {
    /*color: #636b6f !important;*/
    /*padding: 0 25px;*/
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }

  .show ul li a {
    color:black !important;
    padding-left: 5px;
  }

  .img-circle {
    border-radius: 50%;
  }

  .m-b-md {
    margin-bottom: 30px;
  }
  .head_har{
    background-color: #f6f7f9;
    border-bottom: 1px solid #dddfe2;
    border-radius: 2px 2px 0 0;
    font-weight: bold;
    padding: 8px 6px;
  }
  .left-sidebar, .right-sidebar{
    background-color:#fff;
    height:600px;
  }
  .posts_div{
    margin-bottom:10px !important;
  }
  .posts_div h3{
    margin-top:4px !important;
  }
  #postText{
    border:none;
    height:100px
  }
  .likeBtn{
    color: #4b4f56; font-weight:bold; cursor: pointer;
  }
  .left-sidebar li { padding:10px;
    border-bottom:1px solid #ddd;
    list-style:none; margin-left:-20px
  }
  .dropdown-menu{
    min-width:120px; left:-30px
  }
  .dropdown-menu a{
    cursor: pointer;
  }
  .dropdown-divider {
    height: 1px;
    margin: .5rem 0;
    overflow: hidden;
    background-color: #eceeef;
  }
  .user_name{
    font-size:18px;
    font-weight:bold;
    text-transform:capitalize;
    margin:3px
  }
  .all_posts{
    background-color:#fff;
    padding:5px;
    margin-bottom:15px;
    border-radius:5px;
    -webkit-box-shadow: 0 8px 6px -6px #666;
    -moz-box-shadow: 0 8px 6px -6px #666;
    box-shadow: 0 8px 6px -6px #666;
  }
  #commentBox{
    background-color:#ddd;
    padding:10px;
    width:99%; margin:0 auto;
    background-color:#F6F7F9;
    padding:10px;
    margin-bottom:10px
  }

  #commentBox li {
    list-style:none;
    padding:10px; border-bottom:1px solid #ddd
  }
  .commet_form{
    padding:10px;
    margin-bottom:10px
  }
  .commentHand{
    color:blue
  }
  .commentHand:hover{
    cursor:pointer
  }
  .upload_wrap{
    position:relative;
    display:inline-block;
    width:100%
  }
  .center-con{
    max-height:600px;
    position: absolute;
    left:calc(25%);
    overflow-y: scroll;
  }

  @media (min-width: 268px) and (max-width: 768px) {
    .center-con{
      max-height:600px;
      position: relative;
      left:0px;
      overflow-y: scroll;
    }
  }
</style>
