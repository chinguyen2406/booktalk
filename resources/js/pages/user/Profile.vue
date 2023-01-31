<template>
  <div class="col-md-6 col-sm-12 col-xs-12 center-con">
    <div class="row">
      <div class="" v-for="uData in userData" :key="uData.id">
        <div class="panel panel-default">
            <div class="panel-heading"> {{uData.name}}</div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <div class="thumbnail">
                          <h3 align="center">{{uData.name}}</h3>
                          <img :src="'../images/'+ uData.pic" width="120px" height="120px" class="img-circle" style="height: 120px;" />
                          <div class="caption">
                            <p align="center">{{uData.city}} - {{uData.country}}</p>
                            <p align="center" v-if="uData.user_id == auth.id">
                              <router-link :to="{name: 'editProfile'}" class="btn btn-primary" role="button">
                                Edit Profile
                              </router-link>
                            </p>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h4 class=""><span class="label label-default">About</span></h4>
                        <p> {{uData.about}} </p>

                        <div v-if="uData.user_id != auth.id" class="btn btn-primary" role="button">
                          <router-link :to="{name: 'newMessage'}" style="color: rgb(255, 255, 255);">Chat</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{-- Make Post --}} -->
        <!-- up post -->
        <div class="posts_div" v-if="user.id == uData.user_id">
          <div class="head_har">
            <i class="fa fa-edit"></i> {{msg}}
          </div>
          <div style="background-color:#fff; padding:10px">
            <div class="row">
              <div class="col-md-2 col-sm-2 pull-left">
                <img :src="'../images/' + user.pic" style="width:50px; margin:5px;  border-radius:100%; height: 50px;">
              </div>
              <div class="col-md-10 col-sm-10 pull-right">
                <div v-if="!image">
                  <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                  <textarea v-model="content" id="postText" class="form-control"
                  placeholder="what's on your mind ?"></textarea>
                  <button type="submit" class="btn btn-sm btn-primary
                  pull-right" style="margin:10px; padding:5px 15px 5px 15px; background-color:#4267b2" id="postBtn">Post</button>
                  </form>
                </div>

                <div v-if="!image" style="position:relative;display:inline-block">
                  <div style="border:1px solid #ddd; border-radius:10px; background-color:#efefef; padding:3px 15px 3px 10px; margin-bottom:10px">
                    <i class="fa fa-file-image-o"></i> <b>photo</b>
                    <input type="file" @change="onFileChange" style="position:absolute; left:0;top:0; opacity:0"/>
                  </div>
                </div>

                <div v-else>
                  <div class="upload_wrap">
                    <textarea v-model="content" id="postText" class="form-control" placeholder="what's on your mind ?"></textarea>
                    <b @click="removeImg" style="right:0;position:absolute;cursor:pointer">Cancel</b>
                    <img :src="image" style="width:100px; margin:10px;"/><br>
                  </div>
                  <button @click="uploadImg" class="btn btn-sm btn-info pull-right" style="margin:10px">Post</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- {{-- post author --}} -->
        <!-- list posts -->
        <div>
          <div v-for="post,key in posts">
            <div class="col-md-12 all_posts" v-if="post.user_id == uData.user_id">
              <div class="col-md-2 pull-left"  >
                <img :src="'../images/' + post.user.pic" style="width:50px; border-radius:100%; height:50px">
              </div>
              <div class="col-md-10" style="float: right; padding-left: 0px !important;">
                <div class="row">
                  <div class="col-md-10">
                    <p><a  class="user_name"> {{post.user.name}}</a> <br>
                    <span style="color:#AAADB3">  {{ post.created_at | myOwnTime}}
                    <i class="fa fa-globe"></i></span></p>
                  </div>
                  <div class="col-md-1 pull-right">
                    <!-- delete button goes here -->
                    <a href="#" data-toggle="dropdown" style="font-size:40px; color:#ccc; left:-10px" aria-haspopup="true">...</a>
                    <div class="dropdown-menu">
                      <li v-if="post.user_id == user.id">
                        <a data-toggle="modal" :data-target="'#myModal' + post.id"  @click="openModal(post.id)">Edit</a>
                      </li>
                      <li><a>...</a></li>
                      <div class="dropdown-divider"></div>
                      <li v-if="post.user_id == user.id">
                        <a @click="deletePost(post.id)">
                          <i class="fa fa-trash"></i> Delete
                        </a>
                      </li>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" :id="['myModal'+ post.id]" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <!-- <p>updatedContent</p> -->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Post</h4>
                          </div>
                          <div class="modal-body">
                            <textarea v-model="updatedContent" class="form-control"></textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" @click="updatePost(post.id)">Save Changes</button>
                          </div>
                        </div>
                      </div>   
                    </div>
                    <!-- Modal -->
                  </div>
                </div>
              </div>
              <p class="col-md-12 d-flex" style="color:#000; margin-top:15px; font-family:inherit">
                <p>{{post.content}}</p>
                <br>
                <img v-if="post.image" :src="'/images/' + post.image" style="width:100%"/>
              </p>
              <div style="padding:10px; border-top:1px solid #ddd" class="col-md-12">
                <div class="col-md-4 d-inline">
                  <p v-if="post.likes && post.likes.length>=0" class="d-inline">
                    <i class="fa fa-thumbs-up likeBtn" @click="likePost(post.id)" style="color:blue;"> Like</i>
                    <b style="color:green">({{post.likes.length}})</b>
                  </p>
                </div>
                <div class="col-md-4 d-inline">
                  <p @click="commentSeen= post.id" class="commentHand d-inline">Comments <b>({{post.comments.length}})</b></p>
                </div>
              </div>
            </div>
            <div id="commentBox" v-if="commentSeen == post.id">
              <div class="commet_form">
                <!-- send comment-->
                <textarea class="form-control" v-model="commentData[key]" ></textarea>
                <button class="btn btn-success mt-1" @click="addComment(post,key)">Send</button>
              </div>
              <ul v-for="comment in post.comments" :key="comment.id">
                <li >
                  <p v-if="comment.user">
                  <a :href="comment.user.slug">
                    <img  :src="'../images/' + comment.user.pic" width="32" style="margin:5px; height:32px;" class="img-circle"/>
                    {{ comment.user.slug | capitalize }}
                  </a>
                  {{comment.comment}}
                  </p>
                </li>
              </ul>
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
        auth: {
            type: Object
        }
    },
    data() {
      return {
        userData: [],
        msg: 'Make Post:',
        content: '', updatedContent:'',
        posts: [],
        errors: [],
        image:'',
        commentSeen: false,
        successMsg: '',
        commentData:[],
        postId: '',
        comments: [],
        user: {},
      }
    },

    ready: function() {
      this.created();
    },

    created(){
      // get userData
      axios.get('/profile/' + this.$route.params.slug )
      .then(response => {
        this.userData = response.data;
        console.log(this.userData);
      })
      .catch(function (error) {
        console.log(error);
      });

      // get posts
      // axios.get('/posts')
      // .then(response => {
      //   console.log(response); 
      //   this.posts = response.data;
      //   Vue.filter('myOwnTime', function(value){
      //     return moment(value).fromNow();
      //   });
      // })
      // .catch(function (error) {
      //   console.log(error); 
      // });

      // show info user
      axios.get('/user')
      .then(response => {
        this.user = response.data;
        // console.log(this.user);
      })
      .catch(function (error) {
        console.log(error);
      });
    },

    methods: {
      addPost(){
        axios.post('/addPost', { content: this.content })
        .then( (response) =>{
          this.content="";
          console.log('saved successfully'); 
          this.posts = response.data;
          console.log(this.posts);
        })
        .catch(function (error) {
          console.log(error); 
        });
      },

      deletePost(id){
        //alert(id);
        axios.get('/deletePost/' + id)
        .then(response => {
          console.log(response); 
          this.posts = response.data; 
        })
        .catch(function (error) {
          console.log(error); 
        });
      },

      // show content post when edit post
      openModal(id){
        axios.get('/posts/' + id)
        .then(response => {
          console.log(response); 
          this.updatedContent = response.data; 
          console.log(1);
        })
        .catch(function (error) {
          console.log(error); 
        });
      },

      // edit post
      updatePost(id){
        axios.post('/updatePost/' + id, {
          updatedContent: this.updatedContent
        })
        .then( (response) =>{
          this.content="";
          console.log('Changes saved successfully'); 
          this.posts = response.data;
          // console.log(app.posts);
        })
        .catch(function (error) {
          console.log(error); 
        });
      },

      // up anh 
      onFileChange(e){
        var files = e.target.files || e.dataTransfer.files; // fetch FileList object: tìm nạp đối tượng FileList
        console.log(files);
        this.createImg(files[0]); // tai anh len post
      },

      createImg(file){
        // xem truoc hinh anh truoc khi tai len
        var image = new Image;
        var reader = new FileReader;

        reader.onload = (e) =>{
          this.image = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      // likePost
      likePost(id){
        axios.get('/likePost/' + id)
        .then(response => {
          console.log(response); 
          this.posts = response.data; 
        })
        .catch(function (error) {
          console.log(error); 
        });
      },

      addComment(post,key){
        axios.post('/addComment', {
          comment: this.commentData[key],
          id: post.id
        })
        .then(response => {
          console.log('saved successfully'); 
          if(response.status===200){
            // console.log(response.data[key]);
            this.posts = response.data;
            this.commentData[key] = "";
            // app.comments = response.data;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
      },

      // cancel image post up
      removeImg(){
        this.image=""
      },

      uploadImg(){
        axios.post('/saveImg', {
          image: this.image,
          content: this.content
        })
        .then( (response) =>{
          console.log('saved successfully'); 
          this.image= "";
          this.content = "";
          if(response.status===200){
            app.posts = response.data;
          }
        })
        .catch(function (error) {
          console.log(error); 
        });
      },
    },



  }
</script>

<style scoped >

</style>

