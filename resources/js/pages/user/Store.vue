<template>
<div class=" container">
    <div class="row ">
        <div class="col-md-9 ">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    Kho lưu trữ sách
                </div>
                <div class="panel-body category-list table-item">

                    <draggable v-model="books" @end="onEndMove">
                        <transition-group>
                            <div v-for="(book, index) in books" :key="book.id" class="col-xs-6 col-md-3 col-sm-3 ebook">
                                <router-link :to="{name:'book', params: { id: book.bookId } }">
                                    <img :src="'/images/books/'+ book.pic" :alt="book.name" class="img-book" style="width: 111px;">
                                    <p class="book-name" style="    color: rgb(0 0 0);
    padding-top: 15px;">{{book.name}}</p>
                                </router-link>
                            </div>
                        </transition-group>
                    </draggable>

                </div>
                <div v-if="page < last_page && page != last_page" class="text-center">
                    <button type="button " class="btn btn-primary seeMore" @click="seeMore()" style="margin-top: 10px;
    margin-bottom: 10px">
                       Xem thêm
                    </button>
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
    import Draggable from 'vuedraggable';
export default {
    components: { Draggable },
    props: {
        auth: {
            type: Object
        }
    },
    data() {
        return {
            books:[],
            page: 1,
            last_page: '',
            numberPage: 1, // so trang
            onePage: 4,
            categories:[],
        }
    },
    watch: {
        $route(){
            this.categoryId = this.$route.params.id;
            this.getListBooks();
        },
    },
    created() {
        this.getListBooks();
        console.log('auth' + this.auth);
        this.getListCategories();
    },
    methods: {
        seeMore() {
            this.page = this.page + 1;
            this.getListBooks(this.page);
        },

        onEndMove: function(){
            const arraySort = [];
            for (let i = 0; i < this.books.length; i++){
                arraySort.push(this.books[i].id);
            }
            axios.post('/sortBooksStore' , {
                arraySort: arraySort,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        getListCategories(){
            axios.get('/allCategories')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        getListBooks(pageNum){
            axios.get('/booksStore?page=' + pageNum , {
                params: {
                userId: this.auth.id,
                },
            })
            .then(response => {
                console.log(response.data);
                console.log(response.data.books.last_page);
                const notes  = response.data.books.data;
                for (let i = 0; i < notes.length; i++){
                    this.books.push(notes[i]);
                }
                this.last_page = response.data.books.last_page;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
<style lang="scss" scoped >
    .table-item {
        height: 450px;
        overflow-y: scroll;
    }
    @media screen and (min-width: 1400px) {
        .table-item {
            height: 700px;
        }
    }
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

</style>
