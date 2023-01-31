export const state = {
  show_modal_create_category: false,
    show_modal_create_book: {
        show: false,
        categoryId:'',
    },
    show_modal_delete: false,
    id: '',
    model: '',

    show_modal_edit_category: {
        show: false,
        category: {},
    },

    show_modal_edit_book: {
        show: false,
        id: '',
    },
    show_modal_notify_success: {
        show: false,
        model: '',
    },

};
