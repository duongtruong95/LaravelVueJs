<template>
    <div class="lang">
        <select v-model="language" @change="changeLanguage">
            <option v-for="lang in optionLangs" :value="lang.value" >{{lang.text}}</option>
        </select>
        {{lang}} : {{ $t('hello') }}
    </div>
</template>
<script>
    export default {
        data: () => ({
            optionLangs: [
                {
                    text: 'Vietnamese',
                    value: 'vn'
                },
                {
                    text: 'English',
                    value: 'en'
                },
                {
                    text: 'Japanese',
                    value: 'jp'
                },
            ],
            language: 'vn',
        }),
        computed: {
            lang () {
                return this.$store.state.lang;
            }
        },
        methods: {
            changeLanguage() {
                this.$store.dispatch('setLang', this.language)
            }
        }
    };
</script>
