export const actions = {
  showModalCreateCategory({ commit }) {
    commit('SHOW_MODAL_CREATE_CATEGORY');
  },
  hideModalCreateCategory({ commit }) {
    commit('HIDE_MODAL_CREATE_CATEGORY');
  },
    showModalCreateBook({ commit },categoryId) {
        commit('SHOW_MODAL_CREATE_BOOK',categoryId);
    },
    hideModalCreateBook({ commit }) {
        commit('HIDE_MODAL_CREATE_BOOK');
    },
    showModalEditCategory({ commit }, payload) {
        commit('SHOW_MODAL_EDIT_CATEGORY', payload);
    },
    hideModalEditCategory({ commit }) {
        commit('HIDE_MODAL_EDIT_CATEGORY');
    },

    showModalDelete({ commit }, payload) {
        commit('SHOW_MODAL_DELETE', payload);
    },
    hideModalDelete({ commit }) {
        commit('HIDE_MODAL_DELETE');
    },

    showModalEditBook({ commit }, id) {
        commit('SHOW_MODAL_EDIT_BOOK', id);
    },
    hideModalEditBook({ commit }) {
        commit('HIDE_MODAL_EDIT_BOOK');
    },
    showModalNotifySuccess({ commit }, model) {
        commit('SHOW_MODAL_NOTIFY_SUCCESS', model);
    },
    hideModalNotifySuccess({ commit }) {
        commit('HIDE_MODAL_NOTIFY_SUCCESS');
    },
};
