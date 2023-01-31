<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading"> <h3 style="    font-weight: bold;
    text-align: center;">Đăng ký </h3></div>

      <div class="panel-body">
        <div class="alert alert-danger" v-if="has_error && !success">
          <p v-if="error == 'registration_validation_error'">Lỗi xác thực, vui lòng xem thông báo bên dưới.</p>
          <p v-else>Lỗi, không thể đăng ký vào lúc này. Nếu sự cố vẫn tiếp diễn, vui lòng liên hệ với quản trị viên.</p>
        </div>

        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">

          <div class="form-group" v-bind:class="{'has-error': has_error && errors.name}">
            <label for="name">Tên người dùng</label>
            <input id="name" type="text" class="form-control" required autofocus v-model="name">
            <span class="help-block" v-if="has_error && errors.name">{{errors.name}}</span>
          </div>

          <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
            <label for="email">E-mail đăng nhập</label>
            <input type="email" id="email" class="form-control" required placeholder="user@example.com" v-model="email">
            <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
          </div>

          <div class="form-group" style="height: 30px;">
            <label for="name" class="col-md-2 control-label" style="padding-left: 0px;" >Giới tính</label>

            <div class="col-md-6">
              <select name="gender" class="col-md-6 control-label"  v-model="gender">
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
              </select>
            </div>
          </div>

            <label for="name" class="lb" style="  margin-top: 20px;">Thể loại yêu thích: </label>
            <multiselect class="form-control" style="padding: 0px !important;" v-model="value" tag-placeholder="Add this as new tag" placeholder="Thêm thể loại yêu thích" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>

          <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }" style="    margin-top: 30px;">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" required class="form-control" v-model="password">
            <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>
          </div>

          <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
            <label for="password_confirmation">Nhập lại mật khẩu</label>
            <input type="password" id="password_confirmation" required class="form-control" v-model="password_confirmation">
          </div>

          <button type="submit" class="btn btn-primary">Registration </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        gender: '',
        password_confirmation: '',
        has_error: false,
        error: '',
        errors: {},
        success: false,

          options:[],
          value: [],
      }
    },

      created() {
          this.getListCategories();
      },

    methods: {
        addTag (newTag) {
            console.log(newTag);
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(newTag)
            this.value.push(newTag)
        },

        getListCategories(){
            axios.get('/allCategories')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                    for(let i = 0;i < response.data.length;i++)
                    {
                        response.data[i].code = response.data[i].name.substring(0, 2) + Math.floor((Math.random() * 10000000))
                        this.options.push(response.data[i]);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
      register() {
        var app = this
          const likeCate = [];
          for(let i = 0; i < this.value.length; i++){
              likeCate.push(this.value[i].id);
          }


        this.$auth.register({
          data: {
            name: app.name,
            email: app.email,
            gender: app.gender,
            password: app.password,
            password_confirmation: app.password_confirmation,
              likes: likeCate
          },
          success: function () {
            app.success = true
            this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
          },
          error: function (res) {
            console.log(res.response.data.errors)
            app.has_error = true
            app.error = res.response.data.error
            app.errors = res.response.data.errors || {}
          }
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
