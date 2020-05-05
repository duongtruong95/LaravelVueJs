import Vue from 'vue';
import VueI18n from 'vue-i18n';
import vnMessage from '../js/lang/vn.json';
import enMessage from '../js/lang/en.json';
import jpMessage from '../js/lang/jp.json';
Vue.use(VueI18n);

const messages = {
    vn: vnMessage,
    en: enMessage,
    jp: jpMessage,
}
const i18n = new VueI18n({
    locale: 'vn',
    messages,
    fallbackLocale: 'vn',
})

export default i18n
