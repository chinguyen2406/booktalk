<template>
    <div
        :class="{modal: true,show: isShowingModalEditCategory}"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-label w-100 font-weight-bold">Chỉnh sửa thể loại</h4>
                    <button type="button" class="close" aria-label="Close" @click="hide()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form" style="margin-top: 10px;">
                        <input v-model="name" placeholder="Ten the loai" class="name" style="width: 100%">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" @click="hide()">
                        Hủy
                    </button>
                    <button class="btn btn-primary seeMore" aria-label="Close" aria-hidden="true" @click="editCategory()">Done</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import EventBus from '../../app';
    const EDIT_CATEGORY = 'EDIT_CATEGORY';
    export default {
        EDIT_CATEGORY: EDIT_CATEGORY,
        data() {
            return {
                name: '',
                errors: {
                    name: '',
                },
            };
        },
        computed: {
            ...mapGetters('modals', ['isShowingModalEditCategory']),
            ...mapGetters('modals', ['category']),
        },
        watch: {
            isShowingModalEditCategory: function() {
                this.name = this.category.name;
            },
        },
        methods: {
            ...mapActions({
                hide: 'modals/hideModalEditCategory',
            }),
            editCategory() {
                let hasErrors = false;
                axios.put('/categories/' +  this.category.id,{
                        name: this.name,
                })
                    .then(response => {
                        console.log(response.data);
                        if(response.data.success){
                            EventBus.$emit(EDIT_CATEGORY, 'create_category');
                            this.hide();
                            this.name = '';
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
    };
</script>

<style lang="scss" scoped>
    .errors {
        color: red;
    }
</style>
