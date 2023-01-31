<template>
  <div
    :class="{modal: true,show: isShowingModalNotifySuccess}"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4  class="modal-label w-100 font-weight-bold">Thông báo</h4>
          <button type="button" class="close" aria-label="Close" @click="hide()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
          <p >Cập nhật thông tin thành công!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="hide()">OK</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  data() {
    return {
    };
  },
  computed: {
    ...mapGetters('modals', ['isShowingModalNotifySuccess']),
    ...mapGetters('modals', ['modelNotify']),
  },

  methods: {
    ...mapActions({
      hide: 'modals/hideModalNotifySuccess',
    }),
  },
};
</script>

<style lang="scss" scoped>
    .tableSelect {
        float: left;
        margin: 0.8%;
    }

    .modal-body {
        margin-bottom: 30px;
    }

</style>
