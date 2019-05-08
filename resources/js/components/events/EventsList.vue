<template>
  <span>
    <v-toolbar color="primary" dense>
      <v-toolbar-title class="white--text">Events</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-tooltip bottom>
          <v-btn slot="activator" id="events_refresh_button" icon class="white--text" @click="refresh"
                 :loading="loading" :disabled="loading">
              <v-icon>refresh</v-icon>
          </v-btn>
          <span>Actualitzar</span>
      </v-tooltip>
    </v-toolbar>
    <v-card>
      <v-card-title>
         <v-layout>
          <v-flex xs10 style="align-self: flex-end;">
              <v-layout>
                  <v-flex xs4 class="text-sm-left" style="align-self: center;">
                      TODO FILTERS
                  </v-flex>
                  <v-flex xs7>
                  </v-flex>
              </v-layout>
          </v-flex>
          <v-flex xs3>
              <v-text-field
                      append-icon="search"
                      label="Buscar"
                      single-line
                      hide-details
                      v-model="search"
              ></v-text-field>
          </v-flex>
        </v-layout>
      </v-card-title>
      <v-data-table :items="this.dataEvents" :headers="headers" :search="search"
                    no-results-text="No s'ha trobat cap registre coincident" no-data-text="No hi han dades disponibles"
                    rows-per-page-text="Events per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]" :loading="loading"
                    :pagination.sync="pagination">
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
              {{event.session}}
            </td>
            <td>
              {{ event.inscription_type_id }}
            </td>
            <td>
              <!--TODO: Configurar que funcioni muntar imatge al fer click-->
              <v-btn fab dark color="primary">
                <v-img v-if="event.image" :src="event.image"></v-img>
                <v-icon v-else>add</v-icon>
              </v-btn>
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
            <td>
                <event-publish :event="event"></event-publish>
                <event-unarchive :event="event" @unarchived="refresh"></event-unarchive>
                <event-archive :event="event" @archived="refresh"></event-archive>
                <event-delete :event="event"></event-delete>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </span>
</template>
<script>
import EventPublish from './EventPublish'
import EventArchive from './EventArchive'
import EventUnArchive from './EventUnArchive'
import EventDelete from './EventDelete'

export default {
  name: 'EventsList',
  components: {
    'event-publish': EventPublish,
    'event-archive': EventArchive,
    'event-unarchive': EventUnArchive,
    'event-delete': EventDelete
  },
  data () {
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
        { text: 'Sessió', value: 'Sessió' },
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
  },
  methods: {
    refresh () {
      this.loading = true
      window.axios.get('/api/v1/all_events').then((response) => {
        this.dataEvents = response.data
        this.loading = false
        this.$snackbar.showMessage('Events actualitzats correctament')
      }).catch(() => {
        this.loading = false
      })
    }
  }
}

</script>
