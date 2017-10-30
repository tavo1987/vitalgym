<template>
    <div>
        <vuetable ref="vuetable"
                  api-url="/api/v1/users"
                  :fields="fields"
                  :muti-sort="true"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :http-options="{ headers: {Authorization: 'Bearer ' + apiToken }}"
                  :append-params="moreParams"
        >
            <template slot="actions" slot-scope="props">
                <div class="btn-group">
                    <button type="button" class="btn btn-info">Acciones</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a  @click="onAction('edit-item', props.rowData, props.rowIndex)" href="#">Editar</a></li>
                        <li><a  @click="onAction('delete-item', props.rowData, props.rowIndex)"href="#">Eliminar</a></li>
                        <li><a  @click="onAction('view-item', props.rowData, props.rowIndex)" href="#">Ver</a></li>
                    </ul>
                </div>
            </template>
        </vuetable>
        <vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
    </div>
</template>

<script>
    import Vue from 'vue'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'

    export default {
        props:{
            apiToken: { type: String, required: true}
        },
        data() {
            return {
                moreParams: {},
                fields: [
                    {name: 'id', title: 'id', sortField: 'id'},
                    {name: 'name', title: 'Nombre', sortField: 'name'},
                    {name: 'last_name', title: 'Apellido', sortField: 'last_name'},
                    {name: 'nick_name', title: 'Nick Name', sortField: 'nick_name'},
                    {name: 'avatar', title: 'Avatar', callback: 'renderAvatar'},
                    {name: 'email', title: 'Email', sortField: 'email'},
                    {name: 'role', title: 'Tipo', callback: 'roleLabel'},
                    {name: 'active', title: 'Estado', callback: 'statusLabel'},
                    {name: 'last_login', title: 'Última sesión'},
                    {name: '__slot:actions', title: 'Acciones'},
                ]
            }
        },
        computed: {

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
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            editRow(rowData){
                alert("You clicked edit on"+ JSON.stringify(rowData))
            },
            deleteRow(rowData){
                alert("You clicked delete on"+ JSON.stringify(rowData))
            },
            roleLabel (value) {
                return `<span class="badge bg-purple">${value}</span>`
            },
            statusLabel (value) {
                return value
                    ? '<span class="badge bg-green">Activo</span>'
                    : '<span class="badge bg-orange">Inactivo</span>'
            },
            renderAvatar(value) {
                return `<img width="50" class="img-circle img-bordered-sm" src="${value}"/>`
            },
            onAction (action, data, index) {
                alert(`slot action: ' ${action}, ${data.name}, ${index}`)
            },
            onFilterSet(payload) {
                this.moreParams = {'filter': payload},
                Vue.nextTick( () => this.$refs.vuetable.refresh())
                console.log('from user table component:' + payload);
            },
            onFilterReset() {
                this.moreParams = {}
                Vue.nextTick( () => this.$refs.vuetable.refresh())
                console.log('reset:');
            }
        }
    }
</script>
