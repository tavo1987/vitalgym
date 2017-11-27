<template>
    <vg-vuetable api-url="/api/v1/users" :fields="fields" :api-token="$attrs.apitoken">
        <span slot="role" slot-scope="props" class="badge bg-purple">{{ props.rowData.role }}</span>

        <template slot="status" slot-scope="props">
            <span v-if="props.rowData.active" class="badge bg-green">Activo</span>
            <span v-else class="badge bg-orange">Inactivo</span>
        </template>

        <img width="50" class="img-circle img-bordered-sm" slot="avatar" slot-scope="props" :src="props.rowData.avatar"/>

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
        inheritAttrs: false,
        methods: {
            onAction (action, data, index) {
                alert(`slot action: ' ${action}, ${data.name}, ${index}`)
            },
        }
    }
</script>
