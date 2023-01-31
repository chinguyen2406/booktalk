<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading"> <h3 style="    font-weight: bold;
    text-align: center;">Đăng nhập</h3></div>

      <div class="panel-body">
        <div class="alert alert-danger" v-if="has_error">
          <p>Lỗi, email hoặc mật khẩu bạn nhập không chính xác!</p>
        </div>
        <form autocomplete="off" @submit.prevent="login" method="post">
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
          </div>
          <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" class="form-control" v-model="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
    import EventBus from '../app';
    const LOGIN = 'LOGIN';
  export default {
      LOGIN: LOGIN,
    data() {
      return {
        email: null,
        password: null,
        has_error: false,
        posts: [],
      }
    },

    ready: function(){
      this.created();
    },

    created() {
      // axios.get('/posts')
      // .then(response => {
      //   console.log(response);
      //   this.posts = response.data;
      // })
      // .catch(function (error) {
      //   console.log(error);
      // });
    },

    mounted() {
      //
    },

    methods: {
      login() {
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password,
          },
          success: function() {
            // handle redirection
            const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'home-user'
              EventBus.$emit(LOGIN, 'LOGIN');
            this.$router.push({name: redirectTo})
          },
          error: function() {
            app.has_error = true
          },
          rememberMe: true,
          fetchUser: true
        })
        .then(response => {
          console.log(response.headers.authorization);
          const token = response.headers.authorization
          localStorage.setItem('user_token', token) // index the token in localstorage
          console.log(localStorage);
        })
        .catch(err => {
          localStorage.removeItem('user_token')
          reject(err)
        })
      }
    }
  }
</script>

<style scoped>
@media (min-width: 1200px) {
  .container {
      max-width: 720px !important;
  }
}
</style>
