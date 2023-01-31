<template>
  <div class="col-md-6 col-sm-12 col-xs-12 center-con">
    <div class="row">
        <div class="">
          <div class="panel panel-default">
              <div class="panel-heading">{{userd.name}}</div>

              <div class="panel-body">
                  <div class="col-sm-12 col-md-12">
                      <div class="thumbnail">
                          <h3 align="center">{{userd.name}}</h3>
                          <img :src="'../images/' + userd.pic "  width="120px" height="120px" class="img-circle" style="height: 120px;"/>
                          <div class="caption">
                            <p align="center">{{data.city}} - {{data.country}}</p>
                            <p align="center">
                              <router-link :to="{ name: 'changePhoto'}" class="btn btn-primary" role="button">Change Image</router-link>
                            </p>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-12 col-md-12">
                    <div class="col-md-6">
                        <div class="input-group">
                          <span  id="basic-addon1">City Name</span>
                          <input type="text" class="form-control" placeholder="City Name" name="city" v-model="data.city">
                        </div>
                        <br>
                        <div class="input-group">
                          <span  id="basic-addon1">Country Name</span>
                          <input type="text" class="form-control" placeholder="Country Name" name="country"  v-model="data.country">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                          <span  id="basic-addon1">About</span>
                          <textarea type="text" class="form-control" name="about" v-model="data.about">{{ data.about }}</textarea>
                        </div>
                        <br>
                        <div class="input-group">
                          <input type="submit" class="btn btn-success pull-right" @click="updateProfile()" >
                        </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      userd: {
        type: Object
      }
    },

    data() {
      return {
        data: [],
      }
    },

    ready: function() {
      this.created();
    },

    created() {
      // get userData profile
      axios.get('/editProfile')
      .then(response => {
        this.data = response.data;
        console.log(this.data);
      })
      .catch(function (error) {
        console.log(error);
      });
    },

    methods : {
      updateProfile() {
        axios.post('/updateProfile',{
          city: this.data.city,
          country: this.data.country,
          about: this.data.about
        })
        .then((response) =>{
          console.log('Changes profile saved successfully');
          this.$router.push('profile/' + this.userd.slug)

        })
        .catch(function (error) {
          console.log(error);
        });
      }
    },
  }
</script>

<style scoped >

</style>
