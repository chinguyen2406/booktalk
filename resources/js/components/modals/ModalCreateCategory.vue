<template>
  <div
    :class="{modal: true,show: isShowingModalCreateCategory}"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-label w-100 font-weight-bold">Tạo thể loại mới</h4>
          <button type="button" class="close" aria-label="Close" @click="hideModel()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
          <div class="md-form" style="margin-top: 10px;">
            <input v-model="name" placeholder="Nhập tên thể loại mới" class="name" required style="width: 100%">
              <p v-if="errors" class="errors">
                  {{ errors }}
              </p>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary seeMore" aria-label="Close" aria-hidden="true" @click="createCategory()">Done</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import EventBus from '../../app';
const CREATE_CATEGORY = 'CREATE_CATEGORY';
export default {
    CREATE_CATEGORY: CREATE_CATEGORY,
  data() {
    return {
        name: '',
      errors: ''
    };
  },
  computed: {
    ...mapGetters('modals', ['isShowingModalCreateCategory']),
  },
  watch: {
    isShowingModalCreateNote: function(newVal, oldVal) {
      if (!oldVal && newVal) {
        this.errors = '';
      }
    },
  },
  methods: {
    ...mapActions({
      hide: 'modals/hideModalCreateCategory',
    }),

      hideModel() {
          this.name = '';
          this.errors = '';
        this.hide();

      },
      createCategory() {
          this.errors = '';
        let hasErrors = false;
        if(this.name == ''){
            this.errors = 'Trường này là bắt buộc!';
            hasErrors = true;
        }
          if (!hasErrors){
              axios.get('/categories/create',{
                  params: {
                      name: this.name,
                  },
              })
                  .then(response => {
                      console.log(response.data);
                      if(response.data.success){
                          EventBus.$emit(CREATE_CATEGORY, 'create_category');
                          this.hide();
                          this.name = '';
                          this.errors = '';
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
          }

    },
  },
};
</script>

<style lang="scss" scoped>
    .errors {
        color: red;
    }
</style>
