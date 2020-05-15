<template>
    <div>
        <div class="float-left">Showing {{pagination.from}} to {{pagination.to}} of {{pagination.total}} entries</div>
        <ul class="pagination float-right" v-if="pagination.last_page > 1">
            <li v-if="pagination.current_page > 1" class="page-item">
                <a href="#" aria-label="Previous"
                   @click.prevent="changePage(pagination.current_page - 1)" class="page-link">
                    <span aria-hidden="true"><<</span>
                </a>
            </li>
            <li v-for="page in pagesNumber" class="page-item"
                v-bind:class="[ page == isActived ? 'active' : '']">
                <a href="#"
                   @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                <a href="#" aria-label="Next"
                   @click.prevent="changePage(pagination.current_page + 1)" class="page-link">
                    <span aria-hidden="true">>></span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 1
            },
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            changePage: function (page) {
                this.pagination.current_page = page;
            }
        }

    }
</script>

