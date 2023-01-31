
import Vue from 'vue';
import Vuex from 'vuex';
import ModalsModule from './modules/modals/modals.module';

Vue.use(Vuex);

const modules = {
    modals: ModalsModule,
};

const store = new Vuex.Store({
    modules,
});

export default store;
