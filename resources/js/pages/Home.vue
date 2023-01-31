<template>
  <div class="container">
    <div class="card card-default">
      <div class="card-header">
          <h1>ĐỌC SÁCH, TRUYỆN HAY ONLINE VÀ TÀI LIỆU THAM KHẢO MIỄN PHÍ</h1>
      </div>
        <div>
            <ul class="center-block">
                <li class="cat-item"
                    v-for="(category, index) in categories"
                    :key="index"
                >
                    <router-link :to="{name:'category', params: { id: category.id } }">
                        <a-button>
                            <span class="glyphicon glyphicon-folder-open" style="padding-right: 10px;"></span>
                            {{  category.name}}
                        </a-button>
                    </router-link>

                </li>
            </ul>
        </div>
        <div class="text-center mt-4 all-book">
            <router-link :to="{name:'home-user' }" class="btn-ebook view-all-book" title="Xem tất cả sách">
                <a-button type="primary">
                Xem tất cả sách
                </a-button>
            </router-link>
        </div>
        <div style="max-width: 900px;
            margin: 0 auto; margin-top: 30px;">
            <h3 style="    font-weight: bold;">Sách được đọc nhiều nhất</h3>
            <carousel 					:perPage="4"
                                         :autoplay="true"
                                         :loop="true"
                                         :autoplayTimeout="5000"
                                         :navigationEnabled="false"
                                         :paginationEnabled="true">
                <slide v-for="book in books" :key="book.id">
                    <router-link :to="{name:'book', params: { id: book.id } }">
                        <img :src="'/images/books/'+ book.pic" :alt="book.name" class="img-book" style="    max-width: 200px;
    height: 300px;">
                    </router-link>
                </slide>
            </carousel>
        </div>

    </div>
  </div>
</template>

<script>
    import { Carousel, Slide } from 'vue-carousel';
export default {
    components: {
        Carousel,
        Slide
    },
  data() {
      return {
        user: {},
        categories:[],
          books:[],
          pageNumber: this.$route.params.pageNumber, // page so bao nhieu
          // pageNum: Number(this.$route.params.pageNumber),
          pageNum: 1,
          numberPage: 1, // so trang
          onePage: 4,
    }
  },

  ready: function(){
    this.created();
  },

  created() {
        // the loai
      this.getListCategories();
        this.getListBooks();
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
        getListBooks(pageNum){
            axios.get('/booksHot')
                .then(response => {
                    console.log(response.data);
                    this.books = response.data.books.data;
                    this.numberPage = response.data.books.last_page;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        getListCategories(){
            axios.get('/categoryHome')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

<style lang="scss" scoped>

    .all-book {
        text-transform: uppercase;
        .view-all-book {
            /*border: 1px solid rgb(204 204 204);*/
            /*border-radius: 15px;*/
            padding: 8px;
            color: rgb(48 151 209);
        }
    }
    .card-header {
        h1 {
            padding-top: 12px;
            font-size: 21px;
            color: rgb(0 0 0);
            margin-bottom: 25px;
        }
    }
    .cat-item {
        list-style-type: none;
        display: inline-block;
        margin-bottom: 20px;
        a {
            /*border: 1px solid rgb(204 204 204);*/
            /*border-radius: 15px;*/
            padding: 8px;
            margin-right: 10px;
            color: rgb(0 0 0) !important;
        }
    }

</style>
