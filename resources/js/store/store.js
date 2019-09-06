import Vue from 'vue'
import Vuex from 'vuex'
// Modules
import bunq from './modules/bunq'

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules: {
        bunq
    }
});
