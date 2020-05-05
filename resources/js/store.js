import Vue from 'vue'
import Vuex from 'vuex'
import i18n from '../plugin/i18n';
import axios from 'axios'
Vue.use(Vuex)
axios.defaults.baseURL = 'http://localhost/api'
export default new Vuex.Store({
    state: {
        lang: 'vi',
        user: null,
        isLogged: false
    },
    mutations: {
        setUserData (state, userData) {
            state.user = userData.email
            state.isLogged = true
            localStorage.setItem('user', JSON.stringify(userData.token))

        },
        SET_LANG (state, payload) {
            i18n.locale = payload
            state.lang = payload
        },
        clearUserData (state) {
            localStorage.removeItem('user')
            state.isLogged = false;
            location.reload()
        }
    },
    actions: {
        setLang({commit}, payload) {
            commit('SET_LANG', payload)
        },
        login ({ commit }, credentials) {
            return axios
                .post('/login', credentials)
                .then(({ data }) => {
                    commit('setUserData', {token: data.access_token, email: credentials.email})
                })
        },
        logout ({ commit }) {
            commit('clearUserData')
        }
    }
})
