<template>
  <div class="container">
    <div class="card card-default">
        <div class="btn-group-vertical">
            <div class="button-setting">
                <div type="button" class="btn btn-warning st-s" style="margin-left: 0px !important">Quản lí</div>
            </div>
            <div class="button-setting">
                <div class="mini-color" />
                <div class="bt-st">
                    <router-link  to="/admin/categories-manager" v-if="auth.role === 2">
                        <button type="button" class="btn btn-warning st-sp">
                            Thể loại -  Sách
                        </button>
                    </router-link>
                    <router-link to="/super-admin/categories-manager" v-else>
                        <button type="button" class="btn btn-warning st-sp">
                            Thể loại -  Sách
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="button-setting" v-if="auth.role === 3">
                <div class="mini-color" />
                <div class="bt-st">
                    <router-link :to="{name:'users-manager'}">
                        <button type="button" class="btn btn-warning st-sp">
                            Quản lí user
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="button-setting">
                <div class="mini-color" />
                <div class="bt-st">
                    <router-link to="/admin/users-comment" v-if="auth.role === 2">
                        <button type="button" class="btn btn-warning st-sp">
                            Quản lí bình luận
                        </button>
                    </router-link>
                    <router-link to="/super-admin/users-comment" v-else>
                        <button type="button" class="btn btn-warning st-sp">
                            Quản lí bình luận
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="button-setting">
                <div class="mini-color" />
                <div class="bt-st">
                    <router-link :to="{name:'statistical'}" v-if="auth.role === 3">
                        <button type="button" class="btn btn-warning st-sp">
                            Thống kê
                        </button>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="div-right" >
            <router-view />
        </div>
    </div>
  </div>
</template>

<script>

  export default {
      data() {
          return {
              auth: {},
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
      },
  }
</script>

<style lang="scss" scoped>
    .btn-group-vertical {
        width: 275px;
        float: left;
    }
    .div-right {
        height: auto;
        width: 70%;
        background-color: #efefef;
        float: left;
        margin: .5%;
    }
    .st-s {
        background-color: rgb(254 230 122) !important;
        width: 82%;
    }

    .btn {
        color: rgb(0 0 0);
    }
    .mini-color {
        float: left;
        width: 1%;
        background-color: #fee67a;
        margin-left: 7%;
    }

    .bt-st {
        float: left;
        background-color: #fee67a;
        width: 80%;

    }

    .btn-warning {
        background-color: #ffffff !important;
        border: 0;
        border-color: #ffffff;
        width: 100%;
        max-width: 250px;
        margin: 0;
        margin-left: 2%;
    }

    .btn-warning:focus {
        box-shadow: 0 0 0 1px rgba(222, 207, 69, 0.5);
    }

    .st-s {
        background-color: #fee67a !important;
        width: 82%;
    }

    .st-pc {
        background-color: #efefef !important;

    }

    .st-sp {
        background-color: #efefef !important;
    }

    .st-ss {
        background-color: #efefef !important;
    }

    .button-setting {
        margin: 2%;
        width: 260px;
        height: 35px;
    }


</style>
