<template>
    <div class="lang">
        <select name="language" class="form-select" @change="changeLanguage" v-model="language">
            <option value="en">English</option>
            <option value="vi">Tiếng Việt</option>
        </select>
        {{ $t('hello') }}
    </div>
</template>
<script>
    import i18n from '../../plugin/i18n';
    export default {
        data() {
            return {
                language: i18n.locale
            };
        },
        methods: {
            changeLanguage() {
                localStorage.setItem('language', this.language);
                i18n.locale = this.language;
            }
        }
    };
</script>
