<template>
    <div >
        <div class="head-ps">QUẢN LÍ BÌNH LUẬN</div>
        <div class="table-item " >
            <table class="table table-bordered">
                <tr class="row-text">
                    <th>Id</th>
                    <th style="    width: 10%;">Tên người dùng tạo</th>
                    <th style="    width: 30%;">Tên sách</th>
                    <th>Nội dung bình luận</th>
                    <th class="active">
                    </th>
                </tr>
                <tr v-for="comment in comments" :key="comment.id">
                    <td class="color-column">
                        {{ comment.id }}
                    </td>
                    <td class="">{{ comment.userName }}</td>
                    <td class="">{{ comment.bookName }}</td>
                    <td class="">
                        {{ comment.comment }}
                    </td>
                    <td class="active" style="text-align: center;">
                        <a-button
                            type="danger"
                            @click="showModalDeleteCategory(comment.id)"
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
    import ModalCreateCategory from '../../components/modals/ModalCreateCategory';
    import ModalDelete from '../../components/modals/ModalDelete';
    import ModalEditCategory from '../../components/modals/ModalEditCategory';
    import EventBus from '../../app';
    export default {
        props: {
            auth: {
                type: Object
            }
        },
        data() {
            return {
                comments:[],
                // pageNum: Number(this.$route.params.pageNumber),
                pageNum: 1,
                numberPage: 1, // so trang
                onePage: 4,
                model: 'comments',
                userSelect: {},
            }
        },
        created() {
            this.getUsers();
            EventBus.$on(ModalCreateCategory.CREATE_CATEGORY, () => {
                this.getUsers();
            });
            EventBus.$on(ModalDelete.DELETE_COMMENT, () => {
                this.getUsers();
            });
            EventBus.$on(ModalEditCategory.EDIT_CATEGORY, () => {
                this.getUsers();
            });
        },
        methods: {
            ...mapActions({
                showModalCreateCategory: 'modals/showModalCreateCategory',
                showModalEditCategory: 'modals/showModalEditCategory',
                showModalDelete: 'modals/showModalDelete',
            }),

            clickPaginate(pageNum) {
                this.getUsers(pageNum);
            },

            getUsers(pageNum){
                console.log('getUsers');
                axios.get('/allComments?page=' + pageNum)
                    .then(response => {
                        console.log(response.data.users);
                        this.comments = response.data.comments.data;

                        this.numberPage = response.data.comments.last_page;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            showModalDeleteCategory(id){
                const payload = { id: id, model: this.model };
                this.showModalDelete(payload);
            }

        }
    }
</script>
<style lang="scss" scoped >
    .row {
        height: 1000px;
    }
    .table-item {
        height: 400px;
        overflow-y: scroll;
    }
    @media screen and (min-width: 1400px) {
        .table-item {
            height: 700px;
        }
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
        .status-column {
            width: 70%;
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
                background-color: #efefef;
            }
            .delete {
                background-color: #ff8400;
            }
        }
    }
</style>
