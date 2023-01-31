<template>
<div class=" container">
    <div class="row ">
        <div class="col-md-9 ">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    Thông tin cá nhân
                </div>
                <div class="panel-body category-list table-item">
                    <div class="content-ps">
                        <div class="up-avt">
                            <div class="avt">
                                <label class="btn1">
                                    <img v-if="picNew===''" :src="'../images/' + auth.pic" width="100%" height="100%" class="avatar1">
                                    <img v-else :src="picNew" width="100%" height="100%" class="avatar1">
                                    <i class="fas fa-camera" />

                                    <input
                                        type="file"
                                        style="display: none;"
                                        @change="handleUploadFile"
                                    >
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="lb">Tên người dùng: </label>
                            <input
                                id="name"
                                v-model="auth.name"
                                type="text"
                                class="form-control"
                                placeholder=""
                                required
                            >
                            <label for="name" class="lb">Email: </label>
                            <input
                                id="email"
                                v-model="auth.email"
                                type="email"
                                class="form-control"
                                placeholder=""
                                required
                            >

                            <label for="name" class="lb">Thể loại yêu thích: </label>
                            <multiselect class="form-control" style="padding: 0px !important;" v-model="value" tag-placeholder="Add this as new tag" placeholder="Thêm thể loại yêu thích" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>

                            <button
                                type="button"
                                class="btn btn-primary saveInformation"
                                style="    margin-top: 100px;"
                                @click="saveUserInfo()"
                            >Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 sidebar">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Thể Loại Sách
                </div>
                <ul class="nav nav-pills nav-stacked">
                    <li v-for="category in categories" :key="category.id">
                        <router-link :to="{name:'category', params: { id: category.id } }">
                            {{category.name}}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import EventBus from "../../app";
import { mapActions, mapState } from 'vuex';
export default {

    // props: {
    //     auth: {
    //         type: Object
    //     }
    // },
    data() {
        return {
            pageNumber: this.$route.params.pageNumber, // page so bao nhieu
            // pageNum: Number(this.$route.params.pageNumber),
            pageNum: 1,
            numberPage: 1, // so trang
            onePage: 4,
            categories:[],
            options:[],
            value: [],
            picNew: '',
            fileNew: '',
            likes: [],
            auth: {},
        }
    },

    created() {
        axios.get('/user')
            .then(response => {
                this.auth = response.data;
                this.getListCategories();
                this.getLikeCategory();
                console.log(this.user);
            })
            .catch(function (error) {
                console.log(error);
            });
        console.log('auth' + this.auth);




    },
    methods: {
        ...mapActions({
            showModalNotifySuccess: 'modals/showModalNotifySuccess',
        }),
        getLikeCategory(){
            axios.get('/getLikeCategory?userId=' + this.auth.id)
                .then(response => {
                    console.log('getLikeCategory');
                    console.log(response.data);
                    let arr = response.data.data;
                    for(let i = 0; i < arr.length; i++){
                        console.log(arr[i]);
                        this.value.push(arr[i]);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        addTag (newTag) {
            console.log(newTag);
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(newTag)
            this.value.push(newTag)
        },
        saveUserInfo(){
            const formData = new FormData();
            formData.append('name', this.auth.name);
            formData.append('email', this.auth.email);
            formData.append('file', this.fileNew);
            formData.append('id', this.auth.id);

            this.$http.post('/editUser', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }
            ).then(response => {
                if(response.data.success){
                }
            })
            .catch(function (error) {
                console.log(error);
            });
            const likeCate = [];
            for(let i = 0; i < this.value.length; i++){
                likeCate.push(this.value[i].id);
            }

            axios.post('/likeCategory' , {
                    likes: likeCate,
                    userId: this.auth.id
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.showModalNotifySuccess('edit_user');
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
        handleUploadFile(e) {
            this.fileNew = e.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = (e1) => {
                this.picNew = e1.target.result;
            };
        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped >

    .ebook {
        position: relative;
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    }
    .cat-item {
        list-style-type: none;
    }
    .img-book {
        height: 180px;
    }
    .book-name {
        text-align: center;
    }
    .content-container {
        margin-top: 20px;
        height: 550px;
        overflow-y: scroll;
    }
    /*.category-list {*/
    /*    overflow-y: scroll;*/
    /*    height: 420px;*/
    /*}*/
    .book-name {
        height: 60px;
    }
    .pagination {
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    .saveInformation {
        margin-left: 7%;
    }
    .error {
        margin-left: 7%;
        color: red;
    }
    .errorAvatar {
        color: red;
    }
    .up-avt {
        margin-top: 2%;
        margin-bottom: 2%;
        text-align: center;
    }

    .btn1 {
        min-height: 180px;
        min-width: 210px;
        position: relative;
        width: 100%;
        height: 100%;

    }

    .avatar1 {
        height: 200px;
        width: 200px;
        border-radius: 50%;
        position:relative;

    }
    .fa-camera{
        position:absolute;
        left: 53%;
        bottom: 0%;
        font-size:50px;
        color:#9b9e9d;
        z-index:1
    }

    .head-ps {
        background-color: #fee67a;
        height: 4%;
        margin-bottom: 0.5%;
        padding: 10px !important;
        color: #FD8400;
        font-weight: bold;
    }

    .content-setting {
        height: auto;
        width: 70%;
        background-color: #efefef;
        float: left;
        margin: 0.5%;
    }

    .form-control {
        width: 80%;
        margin-left: 7%;
        margin-bottom: 2%;
        margin-top: 1%;
    }

    .lb {
        margin-left: 7%;

    }


</style>
