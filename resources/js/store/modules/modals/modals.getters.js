export const getters = {
  isShowingModalCreateCategory: (state) => {
    return state.show_modal_create_category;
  },
    isShowingModalCreateBook: (state) => {
        return state.show_modal_create_book.show;
    },
    categoryId: (state) => {
        return state.show_modal_create_book.categoryId;
    },
    isShowingModalDelete: (state) => {
        return state.show_modal_delete;
    },
    id: (state) => {
        return state.id;
    },
    model: (state) => {
        return state.model;
    },
    category: (state) => {
        return state.show_modal_edit_category.category;
    },
    isShowingModalEditCategory: (state) => {
        return state.show_modal_edit_category.show;
    },

    isShowingModalNotifySuccess: (state) => {
        return state.show_modal_notify_success.show;
    },
    modelNotify: (state) => {
        return state.show_modal_notify_success.model;
    },

    isShowingModalEditBook: (state) => {
        return state.show_modal_edit_book.show;
    },
    idBookEdit: (state) => {
        return state.show_modal_edit_book.id;
    },

};
