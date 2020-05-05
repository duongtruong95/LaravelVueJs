import Vue from 'vue'
import Vuex from 'vuex'
import i18n from '../plugin/i18n';
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
       lang: 'vi'
    },
    mutations: {
        SET_LANG (state, payload) {
            i18n.locale = payload
            state.lang = payload
        }
    },
    actions: {
        setLang({commit}, payload) {
            commit('SET_LANG', payload)
        }
    }
})
