export default [
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