 <template>
  <div
    :class="{modal: true,show: isShowingModalCreateBook}"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-label w-100 font-weight-bold">Tạo sách mới</h4>
          <button type="button" class="close" aria-label="Close" @click="hideModel()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3" style="    height: 400px;
    overflow-y: scroll;">
          <div class="md-form" style="margin-top: 10px;">
            <label for="name" class="lb">Tên sách </label>
            <input v-model="name" placeholder="" class="name" id="name" style="width: 100%">
              <p v-if="errors.name" class="errors">
                  {{ errors.name }}
              </p>
          </div>
            <div class="md-form" style="margin-top: 10px;">
                <label for="description" class="lb">Mô tả </label>
                <textarea
                    v-model="description"
                    cols="40"
                    rows="3"
                    class="description" id="description" style="width: 100%"
                />
                <p v-if="errors.description" class="errors">
                    {{ errors.description }}
                </p>
            </div>
            <div class="md-form" style="margin-top: 10px;">
                <label for="pic" class="lb">Ảnh bìa </label>
                <input type="file" placeholder="" class="description" id="pic" @change="handleUploadImg" >
                <p v-if="errors.pic" class="errors">
                    {{ errors.pic }}
                </p>
                <img v-if="picNew" class="avatar1" :src="picNew" width="100" style="margin: 10px;">

            </div>
            <div class="md-form" style="margin-top: 10px;">
                <label for="author" class="lb">Tác giả </label>
                <input v-model="author" placeholder="" class="author" id="author" style="width: 100%">
                <p v-if="errors.author" class="errors">
                    {{ errors.author }}
                </p>
            </div>
            <div class="md-form" style="margin-top: 10px;">
                <label for="file" class="lb">File pdf </label>

                <input type="file" class="file" id="file" @change="handleUploadFile">
                <p v-if="errors.file" class="errors">
                    {{ errors.file }}
                </p>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary seeMore" aria-label="Close" aria-hidden="true" @click="createBook()">Done</button>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import EventBus from '../../app';
const CREATE_BOOK = 'CREATE_BOOK';
export default {
    CREATE_BOOK: CREATE_BOOK,
  data() {
    return {
        name: '',
        pic: '',
        picNew: '',
        description: '',
        author: '',
        file: '',
      errors: {
          name: '',
          pic: '',
          picNew: '',
          description: '',
          author: '',
          file: '',
      },
    };
  },
  computed: {
    ...mapGetters('modals', ['isShowingModalCreateBook']),
    ...mapGetters('modals', ['categoryId']),
  },
  watch: {
    isShowingModalCreateNote: function(newVal, oldVal) {
      if (!oldVal && newVal) {
        this.errors = {
            name: '',
            pic: '',
            picNew: '',
            description: '',
            author: '',
            file: '',
        };
      }
    },
  },
  methods: {
    ...mapActions({
      hide: 'modals/hideModalCreateBook',
    }),
      hideModel() {
          this.name =  '',
              this.pic =  '',
              this.picNew =  '',
              this.description =  '',
              this.author =  '',
              this.file = '',
          this.errors = {
              name: '',
              pic: '',
              picNew: '',
              description: '',
              author: '',
              file: '',
          };
          this.hide();

      },

      createBook() {
          this.errors = {
              name: '',
              pic: '',
              picNew: '',
              description: '',
              author: '',
              file: '',
          };
        let hasErrors = false;
          if(this.name == ''){
              this.errors.name = 'Trường này là bắt buộc!';
              hasErrors = true;
          }
          if(this.pic == ''){
              this.errors.pic = 'Trường này là bắt buộc!';
              hasErrors = true;
          }
          if(this.description == ''){
              this.errors.description = 'Trường này là bắt buộc!';
              hasErrors = true;
          }
          if(this.author == ''){
              this.errors.author = 'Trường này là bắt buộc!';
              hasErrors = true;
          }
          if(this.file == ''){
              this.errors.file = 'Trường này là bắt buộc!';
              hasErrors = true;
          }


          if (!hasErrors){
              const formData = new FormData();
              formData.append('name', this.name);
              formData.append('pic', this.pic);
              formData.append('description', this.description);
              formData.append('author', this.author);
              formData.append('file', this.file);
              formData.append('category_id', this.categoryId);

              this.$http.post('/books', formData, {
                      headers: {
                          'Content-Type': 'multipart/form-data',
                      },
                  }
              ).then(response => {
                  if(response.data.success){
                      EventBus.$emit(CREATE_BOOK, 'create_category');
                      this.name =  '',
                          this.pic =  '',
                          this.picNew =  '',
                          this.description =  '',
                          this.author =  '',
                          this.file = '',
                          this.hideModel();
                  }
              })
                  .catch(function (error) {
                      console.log(error);
                  });
          }
    },
      handleUploadImg(e) {
          this.pic = e.target.files[0];
          const reader = new FileReader();
          reader.readAsDataURL(this.pic);
          reader.onload = (e) => {
              this.picNew = e.target.result;
          };
      },

      handleUploadFile(e) {
          this.file = e.target.files[0];
          const reader = new FileReader();
          reader.readAsDataURL(this.file);
      }

  },
};
</script>

<style lang="scss" scoped>
    .errors {
        color: red;
    }
    .modal-body {
        overflow-y: scroll;
        height: 400px;
    }
</style>
