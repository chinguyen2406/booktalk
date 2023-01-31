export const mutations = {
  SHOW_MODAL_CREATE_CATEGORY: (state) => {
    state.show_modal_create_category = true;
  },
  HIDE_MODAL_CREATE_CATEGORY: (state) => {
    state.show_modal_create_category = false;
  },
    HIDE_MODAL_CREATE_BOOK: (state) => {
        state.show_modal_create_book.show = false;
    },
    SHOW_MODAL_CREATE_BOOK: (state, categoryId) => {
        state.show_modal_create_book.show = true;
        state.show_modal_create_book.categoryId = categoryId;
    },
    SHOW_MODAL_DELETE: (state, payload) => {
        state.show_modal_delete = true;
        state.id = payload.id;
        state.model = payload.model;
    },
    HIDE_MODAL_DELETE: (state) => {
        state.show_modal_delete = false;
    },

    SHOW_MODAL_EDIT_CATEGORY: (state, payload) => {
        state.show_modal_edit_category.show = true;
        state.show_modal_edit_category.category = payload;
    },
    HIDE_MODAL_EDIT_CATEGORY: (state) => {
        state.show_modal_edit_category.show = false;
    },

    SHOW_MODAL_EDIT_BOOK: (state, id) => {
        state.show_modal_edit_book.show = true;
        state.show_modal_edit_book.id = id;
    },
    HIDE_MODAL_EDIT_BOOK: (state) => {
        state.show_modal_edit_book.show = false;
    },

    SHOW_MODAL_NOTIFY_SUCCESS: (state, model) => {
        state.show_modal_notify_success.show = true;
        state.show_modal_notify_success.model = model;
    },
    HIDE_MODAL_NOTIFY_SUCCESS: (state) => {
        state.show_modal_notify_success.show = false;
        state.show_modal_notify_success.model = '';
    },
};
