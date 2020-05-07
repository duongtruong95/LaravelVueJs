import Vue from 'vue';
import Vuex from 'vuex';
import i18n from '../../plugin/i18n';
import axios from 'axios';

Vue.use(Vuex);
Vue.use(i18n);

axios.defaults.baseURL = '/api';
const dataUser = JSON.parse(localStorage.getItem('user'));

export default new Vuex.Store({
    state: {
        lang: localStorage.getItem('lang') || 'vn',
        isLogged: !!dataUser,
        user: dataUser,
    },
    mutations: {
        setUserData(state, userData) {
            state.user = userData
            state.isLogged = true
            localStorage.setItem('user', JSON.stringify(userData))

        },
        setLang(state, payload) {
            state.lang = payload
            i18n.locale = payload
            localStorage.setItem('lang', payload)
        },
        clearUserData(state) {
            localStorage.removeItem('user')
            state.isLogged = false
            location.reload()
        }
    },
    actions: {
        setLang({commit}, payload) {
            commit('setLang', payload)
        },
        login({commit}, credentials) {
            return axios
                .post('/login', credentials)
                .then(({data}) => {
                    commit('setUserData', {token: data.access_token, email: credentials.email})
                })
        },
        logout({commit}) {
            commit('clearUserData')
        }
    }
})
