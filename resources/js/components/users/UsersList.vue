<template>
    <span>
    <v-toolbar color="primary">
      <v-toolbar-title class="white--text">Usuaris</v-toolbar-title>
    </v-toolbar>
    <v-card>
      <v-card-title>
        <v-layout wrap>
          <v-flex lg5>
            <v-text-field append-icon="search" label="Buscar" v-model="search"></v-text-field>
          </v-flex>
        </v-layout>
      </v-card-title>
      <v-data-table :items="this.dataUsers" :headers="headers" :search="search" no-results-text="No s'ha trobat cap registre coincident" no-data-text="No hi han dades disponibles" rows-per-page-text="Events per pàgina" :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]" :loading="loading" :pagination.sync="pagination">
        <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
        <template slot="items" slot-scope="{item:user}">
          <tr>
            <td>
              {{user.id}}
            </td>
            <td>
              {{user.email}}
            </td>
            <td>
              {{user.name}}
            </td>
            <td>
              {{user.givenName}}
            </td>
            <td>
              {{ user.sn1 }}
            </td>
            <td>
              {{ user.sn2 }}
            </td>
            <td>
              {{ user.manager }}
            </td>
            <td>
              {{ user.admin }}
            </td>
            <td>
              {{ user.created_at }}
            </td>
            <td>
              {{ user.updated_at }}
            </td>
              <td>
              TODO ACCIONS
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </span>
</template>

<script>
export default {
  name: 'UsersList',
  data() {
    return {
      search: '',
      dataUsers: this.users,
      loading: false,
      pagination: {
        rowsPerPage: 50
      },
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Correu electrònic', value: 'email' },
        { text: 'Nom complet', value: 'name' },
        { text: 'Nom', value: 'givenName' },
        { text: 'Cognom 1', value: 'sn1' },
        { text: 'Cognom 2', value: 'sn2' },
        { text: 'Admin', value: 'admin' },
        { text: 'Manager', value: 'manager' },
        { text: 'Creat', value: 'created_at' },
        { text: 'Modificat', value: 'updated_at' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ]
    }
  },
  props: {
    users: {
      type: Array,
      required: true
    }
  }
}
</script>
