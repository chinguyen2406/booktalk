<template>
<div class=" container">
    <div class="row ">
        <div class="col-md-9 ">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{categoryName}}
                </div>
                <div class="panel-body category-list table-item">
                    <div class="col-xs-6 col-md-3 col-sm-3 ebook"
                        v-for="(book, index) in books"
                        :key="index"
                    >
                        <router-link :to="{name:'book', params: { id: book.id } }">
                            <img :src="'/images/books/'+ book.pic" :alt="book.name" class="img-book" style="width: 111px;">
                            <p class="book-name" style="    color: rgb(0 0 0);
    padding-top: 15px;">{{book.name}}</p>
                        </router-link>
                    </div>
                </div>
                <div v-if="numberPage>=2" class="overflow-auto">
                    <paginate
                        v-model="pageNum"
                        :page-count="numberPage"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="clickPaginate"
                        prev-text="<<"
                        next-text=">>"
                        :container-class="'pagination'"
                        :page-class="'page-item'"
                        :prev-class="'page-item'"
                        :next-class="'page-item'"
                        :page-link-class="'page-link-item'"
                        :prev-link-class="'page-link-item'"
                        :next-link-class="'page-link-item'"
                        :active-class="'active-class'"
                        :hide-prev-next="true"
                    />
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
export default {
    // props: {
    //     auth: {
    //         type: Object
    //     }
    // },
    data() {
        return {
            auth: {},
            categoryId: '',
            categoryName: '',
            books:[],
            pageNumber: this.$route.params.pageNumber, // page so bao nhieu
            // pageNum: Number(this.$route.params.pageNumber),
            pageNum: 1,
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
        this.categoryId = this.$route.params.id;
        this.getListBooks();
        axios.get('/user')
            .then(response => {
                this.auth = response.data;

                console.log(this.user);
            })
            .catch(function (error) {
                console.log(error);
            });
        console.log('auth' + this.auth);
        this.getListCategories();
    },
    methods: {
        clickPaginate(pageNum) {
            this.getListBooks(pageNum);
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
            axios.get('/booksInCategory?page=' + pageNum , {
                params: {
                categoryId: this.categoryId,
                },
            })
            .then(response => {
                console.log(response.data);
                this.books = response.data.books.data;
                this.categoryName = response.data.name[0].name;
                this.numberPage = response.data.books.last_page;
            })
            .catch(function (error) {
                console.log(error);
            });
        },


    }
}
</script>
<style lang="scss"  >
    .nav > li > a:hover, .nav > li > a:focus {
        text-decoration: none;
        background-color: rgb(238 238 238);
        color: rgb(0 0 0);
    }

    .img-book {
        box-shadow: rgba(0, 0, 0, 0.15) 5px 5px 5px 5px;
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
    /*.content-container {*/
    /*    margin-top: 20px;*/
    /*    height: 550px;*/
    /*    overflow-y: scroll;*/
    /*}*/
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
