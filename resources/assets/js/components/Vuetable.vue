<script>
    import Vue from 'vue'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'

    export default {
        render(h) {
            return h(
                'div',
                [
                    h('filter-bar'),
                    this.renderVuetable(h),
                    this.renderPagination(h)
                ]
            )
        },
        data() {
            return {
                queryParams:{
                    sort: 'orderBy',
                    page: 'page',
                    perPage: 'per_page'
                },
                moreParams: {
                    orderDirection: 'desc',
                },
            }
        },
        props:{
            apiToken: { type: String, required: true},
            apiUrl: { type: String, required: true},
            fields: { type: Array, required: true},
            apiToken: { type: String,
                default() {
                    return []
                }
            },
            appendParams: {
                type: Object,
                default() {
                    return {}
                }
            },
        },
        components: {
            VuetablePagination,
            Vuetable,
        },
        mounted() {
            this.$eventHub.$on('filter-set', eventData => this.onFilterSet(eventData))
            this.$eventHub.$on('filter-reset', e => this.onFilterReset())
        },
        methods: {
            getSortParam(sortOrder) {
                return sortOrder.map( sort => {
                    this.moreParams.orderDirection = sort.direction
                    return sort.field
                }).join(',');
            },
            onFilterSet(payload) {
                this.moreParams = {'filter': payload},
                    Vue.nextTick( () => this.$refs.vuetable.refresh())
            },
            onFilterReset() {
                this.moreParams = {}
                Vue.nextTick( () => this.$refs.vuetable.refresh())
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            renderVuetable(h) {
                return h(
                    'vuetable',
                    {
                        ref: 'vuetable',
                        props: {
                            apiUrl: this.apiUrl,
                            fields: this.fields,
                            queryParams: this.queryParams,
                            paginationPath: "",
                            appendParams: this.moreParams,
                            httpOptions: { headers: {Authorization: 'Bearer ' + this.apiToken }}
                        },
                        on:{
                            'vuetable:pagination-data': this.onPaginationData,
                        },
                        scopedSlots: this.$scopedSlots
                    },
                )
            },
            renderPagination(h) {
                return h(
                    'div',
                    { class: {'vuetable-pagination': true, 'ui': true, 'basic': true, 'segment': true, 'grid': true} },
                    [
                        h('vuetable-pagination', {
                            ref: 'pagination',
                            on: {
                                'vuetable-pagination:change-page': this.onChangePage
                            }
                        })
                    ]
                )
            },
        }
    }
</script>
