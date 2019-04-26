<template>
  <span>
    <v-toolbar color="primary">
      <v-toolbar-title class="white--text">Events</v-toolbar-title>
    </v-toolbar>
    <v-card>
      <v-card-title>
        <v-layout wrap>
          <v-flex lg5>
            <v-text-field append-icon="search" label="Buscar" v-model="search"></v-text-field>
          </v-flex>
        </v-layout>
      </v-card-title>
      <v-data-table :items="this.dataEvents" :headers="headers" :search="search" no-results-text="No s'ha trobat cap registre coincident" no-data-text="No hi han dades disponibles" rows-per-page-text="Events per pàgina" :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]" :loading="loading" :pagination.sync="pagination">
        <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
        <template slot="items" slot-scope="{item:event}">
          <tr>
            <td>
              {{event.id}}
            </td>
            <td>
              {{event.name}}
            </td>
            <td>
              {{ event.inscription_type_id }}
            </td>
            <td>
              <v-img :src="event.image"></v-img>
            </td>
            <td>
              <a :href="event.regulation" target="_blank">{{ event.name }}</a>
            </td>
            <td>
              {{ event.participants_number }}
            </td>
            <td>
              {{ event.published_at }}
            </td>
            <td>
              {{ event.deleted_at }}
            </td>
            <td>
              {{ event.created_at }}
            </td>
            <td>
              {{ event.updated_at }}
            </td>
            <!-- <td class="d-flex">
              <event-show v-if="$can('user.events.show')" :users="users" :event="event" :uri="uri" :loading="showing" :disabled="showing"></event-show>
              <event-update v-if="$can('user.events.update')" :users="users" :event="event" @updated="updateTask" :uri="uri" :loading="editing" :disabled="editing"></event-update>
              <event-destroy v-if="$can('user.events.destroy')" :event="event" @removed="removeTask" :uri="uri"></event-destroy>
            </td> -->
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </span>
</template>
<script>
export default {
  name: 'EventsList',
  data() {
    return {
      search: '',
      dataEvents: this.events,
      loading: false,
      pagination: {
        rowsPerPage: -1
      },
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Nom', value: 'name' },
        { text: 'Tipus de inscripció', value: 'inscription_type_id' },
        { text: 'Imatge', value: 'image' },
        { text: 'Reglament', value: 'regulation' },
        { text: 'Número de participants', value: 'participants_number' },
        { text: 'Publicat', value: 'published_at' },
        { text: 'Esborrat', value: 'deleted_at' },
        { text: 'Creat', value: 'created_at' },
        { text: 'Modificat', value: 'updated_at' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ]
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  }
}

</script>
