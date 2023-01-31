<template>
  <div>
    <modal-create-category />
      <modal-delete></modal-delete>
      <modal-edit-category/>
      <modal-create-book/>
      <modal-edit-book/>
      <modal-notify-success/>
  </div>
</template>

<script>
import ModalCreateCategory from '../../components/modals/ModalCreateCategory';
import ModalDelete from '../../components/modals/ModalDelete';
import ModalEditCategory from '../../components/modals/ModalEditCategory';
import ModalCreateBook from '../../components/modals/ModalCreateBook';
import ModalEditBook from '../../components/modals/ModalEditBook';
import ModalNotifySuccess from '../../components/modals/ModalNotifySuccess';

export default {
  components: {
    ModalCreateCategory,
      ModalDelete,
      ModalEditCategory,
      ModalCreateBook,
      ModalEditBook,
      ModalNotifySuccess
  },
};
</script>

<style lang="scss">
    .pagination {
        justify-content: center;
        display: flex;
        padding-left: 0;
        list-style: none;
        margin-top: 1rem;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .active-class {
        .page-link-item {
            color: rgb(255 0 0);
        }
    }

    .modal.show {
        display: block !important;
        background-color: rgba(29, 32, 45, .5);
    }
    .modal-header .close {
        padding: 0.5rem 0.5rem !important;
        margin: -0.5rem -0.5rem -0.5rem auto !important;
        border: 1px solid orange !important;
        border-radius: 0.25rem;
    }

    .modal-header .close:hover {
        color: #fff;
        background-color: #227dc7;
        border-color: #2176bd !important;
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(0.3rem - 1px);
        border-top-right-radius: calc(0.3rem - 1px);
    }
    .modal-header {
        background-color: #fee67a;
        text-align: center;
        color: black;
        text-transform: uppercase;
        .modal-label {
            margin-bottom: 0px !important;
        }
    }

</style>
