<template>
  <div class="col-md-6 col-sm-12 col-xs-12 center-con">
        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">{{userd.name}}</div>
                    <div class="panel-body">       
                        <div class="">
                            <p> Welcome to your profile </p>
                            <img :src="'/images/' + userd.pic" width="100px" height="100px"/><br>
                            <br>
                            <hr>
                                <input type="file" class="form-control" id="file" ref="file" v-on:change="handleFileUpload()" />
                                <input type="submit" class="btn btn-success" name="btn"  @click="updateAvatar()" /> 
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
        avatar: '',
        //
      }
    },

    methods: {
        handleFileUpload(){
            this.avatar = this.$refs.file.files[0];
            console.log(this.avatar);
        },

        // edit avatar user profile
        updateAvatar(){
            let formData = new FormData();
            formData.append('avatar', this.avatar);

            this.axios.post('/uploadPhoto/',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'                   
                    }
                }
            )
            .then( responese =>{
                if(this.avatar.name) {
                    this.userd.pic = this.avatar.name;
                }
                console.log(this.userd.pic);
                console.log('Changes save successfully');
                console.log(formData);
                this.$router.push('editProfile');
                // console.log(this.$router);

            })
            .catch(function (error){
                console.log(error)
            });
        }
    },
  }
</script>

