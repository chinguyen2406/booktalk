<template>
    <div >
        <div class="head-ps">{{categoryName}}</div>
        <div class="table-item " >
            <table class="table table-bordered">
                <tr class="row-text">
                    <th>Id</th>
                    <th>Tên sách</th>
                    <th>Ảnh bìa</th>
                    <th>Tác giả</th>
                    <th style="width: 10%">Lượt xem</th>
                    <th class="active">
                        <a-button type="primary"
                                  @click="showModalCreateBook(categoryId)"
                        >
                            <i class="fas fa-plus" />
                        </a-button>
                    </th>
                </tr>
                <tr v-for="book in books" :key="book.id">
                    <td class="color-column">
                        {{ book.id }}
                    </td>
                    <td class="name-column">
                        <router-link :to="{name:'book', params: { id: book.id } }">
                            {{ book.name }}
                        </router-link>
                    </td>
                    <td class="pic-column">
                        <img :src="'/images/books/'+ book.pic" :alt="book.name" class="img-book" width="100" >
                    </td>
                    <td class="author-column">{{ book.author }}</td>
                    <td class="color-column">{{ book.totalView }}</td>
                    <td class="active">
                        <a-button type="primary"
                          @click="showEditBook(book.id)"
                        >
                            <i class="fas fa-pencil-alt" />
                        </a-button>

                        <router-link :to="{name:'book', params: { id: book.id } }">
                            <a-button>
                                <i class="fas fa-book"></i>
                            </a-button>
                        </router-link>
                        <a-button
                            type="danger"
                            @click="showModalDeleteBook(book.id)"
                            style="    margin-top: 5px;"
                            >
                            <i class="fas fa-eraser" />
                        </a-button>
                    </td>
                </tr>
            </table>
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
</template>
<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalCreateBook from '../../components/modals/ModalCreateBook';
    import ModalDelete from '../../components/modals/ModalDelete';
    import ModalEditBook from '../../components/modals/ModalEditBook';
    import EventBus from '../../app';
    export default {
        props: {
            auth: {
                type: Object
            }
        },
        data() {
            return {
                categoryId: '',
                categoryName: '',
                books:[],
                pageNumber: this.$route.params.pageNumber, // page so bao nhieu
                // pageNum: Number(this.$route.params.pageNumber),
                pageNum: 1,
                numberPage: 1, // so trang
                onePage: 4,
                model: 'book',
            }
        },
        created() {
            this.categoryId = this.$route.params.id;
            this.getListBooks();
            EventBus.$on(ModalCreateBook.CREATE_BOOK, () => {
                this.getListBooks();
            });
            EventBus.$on(ModalDelete.DELETE_BOOK, () => {
                this.getListBooks();
            });
            EventBus.$on(ModalEditBook.EDIT_BOOK, () => {
                this.getListBooks();
            });
        },
        methods: {
            ...mapActions({
                showModalCreateBook: 'modals/showModalCreateBook',
                showModalEditBook: 'modals/showModalEditBook',
                showModalDelete: 'modals/showModalDelete',
            }),

            clickPaginate(pageNum) {
                this.getListBooks(pageNum);
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

            showModalDeleteBook(id){
                const payload = { id: id, model: this.model };
                this.showModalDelete(payload);
            },

            showEditBook(id){
                this.showModalEditBook(id);
            }

        }
    }
</script>
<style lang="scss" scoped >
    .row {
        height: 1000px;
    }
    .head-ps {
        background-color: #fee67a;
        height: 4%;
        margin-bottom: 20px;
        padding-left: 2%;
        padding-top: .7%;
        padding-bottom: .7%;
        color: #636b6f;
        font-weight: 700;
        font-size: 18px;
    }

    .table-item {
        height: auto;
        margin-bottom: 2%;
    }
    .table-item {
        height: 450px;
        overflow-y: scroll;
    }
    @media screen and (min-width: 1400px) {
        .table-item {
            height: 700px;
        }
    }

    .header {
        background-color: #fee67a;
        height: 4%;
        padding-left: 2%;
        padding-top: 0.7%;
        color: #FD8400;
        font-weight: bold;
    }
    .label {
        margin: 2% 0 0.5% 5.5%;
    }
    th, td {
        border: 1px solid #dee2e6;
    }
    .table td, .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-bordered {
        height: auto;
        width: 96%;
        max-width: 1300px;
        background-color: #ffffff;
        margin: 0 2%;
        .color-column {
            width: 5%;
            text-align: center;
            .status-color {
                background-color: #3f9ae5;
                width: 227px;
                height: 37px;
            }
        }
        .name-column {
            width: 30%;
            text-align: left;
            padding: 2.2% 0 0 3%;;
        }
        .pic-column {
            width: 20%;
            text-align: left;
            padding: 2.2%;
        }
        .author-column {
            width: 20%;
            text-align: left;
            padding: 2.2% 0 0 3%;;
        }
        .row-text {
            th {
                text-align: center !important;
            }
            text-align: center;
        }
        .active {
            .add {
                background-color: #3fe576;
            }
            .edit {
                color: #fff;
                background-color: #1890ff;
                border-color: #1890ff;
                text-shadow: 0 -1px 0 rgba(0,0,0,.12);
                box-shadow: 0 2px 0 rgba(0,0,0,.045);
            }
            .delete {
                background-color: #ff8400;
            }
            .books {

            }
        }
    }
</style>
