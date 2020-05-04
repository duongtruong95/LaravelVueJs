import Vue from 'vue'
import VueI18n from 'vue-i18n'
import Locale from "../js/vue-i18n-locales.generated";

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: 'vi',
    messages: Locale,
    fallbackLocale: 'vi',
})

export default i18n
