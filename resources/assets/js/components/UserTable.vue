<template>
    <vg-vuetable api-url="/api/v1/users" :fields="fields" :api-token="apiToken" :methods="{testing}">
        <div class="btn-group" slot="actions" slot-scope="props">
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
    </vg-vuetable>
</template>

<script>
    import userFields  from './../field-definitions/userFields'

    export default {
        data() {
            return {
                fields: userFields
            }
        },
        props: {
            apiToken: {
                type: String,
                required: true,
            }
        },
        mounted() {
          //console.log(this.apiToken);
        },
        methods: {
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
        }
    }
</script>
