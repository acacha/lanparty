<template>
  <span>
    <v-toolbar color="primary" dense>
      <v-toolbar-title class="white--text">Esdeveniments</v-toolbar-title>
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
          <v-flex xs6 style="align-self: flex-end;">
              <v-layout>
                  <v-flex xs7 class="text-sm-left" style="align-self: center;">
                      <v-select
                        label="Filtres"
                        :items="filters"
                        v-model="filter"
                        item-text="name"
                        :return-object="true"
                      ></v-select>
                  </v-flex>
              </v-layout>
          </v-flex>
          <v-flex xs7 style="align-self: flex-end;">
            <v-layout>
              <v-flex xs6 class="text-sm-left" style="align-self: center;">
                <session-select v-model="session"></session-select>
              </v-flex>
            </v-layout>
          </v-flex>
          <v-flex xs6>
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
      <v-data-table :items="getFilteredEvents" :headers="headers" :search="search"
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
              <v-edit-dialog
                :return-value.sync="event.name"
                lazy
                @save="save(event)"
                @cancel="cancel"
                @close="close"
              >{{event.name}}
                <template v-slot:input>
                  <v-text-field
                    v-model="event.name"
                    :rules="[max25chars]"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </td>
            <td>
              {{event.session}}
            </td>
            <td>
              {{ event.inscription_type_id }}
            </td>
            <td>
              <event-image-upload :event="event" @change="refresh(false)"></event-image-upload>
            </td>
            <td>
              <a :href="event.regulation" target="_blank">{{ event.name }}</a>
            </td>
            <td>
              {{ event.participants_number }}
            </td>
            <td :title="event.formatted_published_at">
              {{ event.formatted_published_at_diff }}
            </td>
            <td :title="event.formatted_deleted_at">
              {{ event.formatted_deleted_at_diff }}
            </td>
            <td :title="event.formatted_created_at">
              {{ event.formatted_created_at_diff }}
            </td>
            <td :title="event.formatted_updated_at">
              {{ event.formatted_updated_at_diff }}
            </td>
            <td class="d-flex">
                <event-show :event="event"></event-show>
                <event-update :event="event" @updated="updateEvent"></event-update>
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
import EventUpdate from './EventUpdate'
import EventShow from './EventShow'
import SessionSelect from '../SessionSelect.vue'
import EventImageUpload from './EventImageUpload'

export default {
  name: 'EventsList',
  components: {
    EventImageUpload,
    'event-publish': EventPublish,
    'event-archive': EventArchive,
    'event-unarchive': EventUnArchive,
    'event-delete': EventDelete,
    'event-update': EventUpdate,
    'event-show': EventShow,
    'SessionSelect': SessionSelect,
    'event-image-upload': EventImageUpload
  },
  data () {
    return {
      search: '',
      dataEvents: this.events,
      loading: false,
      max25chars: v => v.length <= 25 || 'Nom de la tasca massa llarg!',
      pagination: {
        rowsPerPage: -1
      },
      filter: { name: 'Totes', value: 'tots' },
      filters: [
        { name: 'Tots', value: 'tots' },
        { name: 'Archivats', value: '!arxivat' },
        { name: 'Actius', value: null }
      ],
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Nom', value: 'name' },
        { text: 'Sessió', value: 'Sessió' },
        { text: 'Tipus de inscripció', value: 'inscription_type_id' },
        { text: 'Imatge', value: 'image' },
        { text: 'Reglament', value: 'regulation' },
        { text: 'Número de participants', value: 'participants_number' },
        { text: 'Publicat', value: 'published_at_timestamp' },
        { text: 'Esborrat', value: 'deleted_at_timestamp' },
        { text: 'Creat', value: 'created_at_timestamp' },
        { text: 'Modificat', value: 'updated_at_timestamp' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ],
      session: undefined
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  },
  computed: {
    getFilteredEvents () {
      return this.dataEvents.filter((event) => {
        let filterArxivat = true
        if (this.filter.value === '!arxivat' && event.deleted_at !== null) {
          filterArxivat = true
        } else if (this.filter.value === null && event.deleted_at === null) {
          filterArxivat = true
        } else if (this.filter.value === 'tots') {
          filterArxivat = true
        } else filterArxivat = false

        let filterSession = true
        if (this.session === undefined) {
          filterSession = true
        } else if (this.session === event.session) {
          filterSession = true
        } else {
          filterSession = false
        }

        return filterSession && filterArxivat
      })
    }
  },
  methods: {
    refresh () {
      this.loading = true
      window.axios.get('/api/v1/all_events').then((response) => {
        this.dataEvents = response.data
        this.loading = false
        this.$snackbar.showMessage('Esdeveniment actualitzats correctament')
      }).catch(() => {
        this.loading = false
      })
    },
    updateEvent () {
      this.refresh()
    },
    save (event) {
      this.loading = true
      window.axios.put('/api/v1/events/inline/' + event.id,
        {
          name: event.name
        }
      ).then(() => {
        this.refresh()
        this.loading = false
        this.$snackbar.showMessage("S'ha actualitzat correctament")
      }).catch(() => {
        this.loading = false
      })
    },
    close () {
      this.$snackbar.showSnackBar('Dialeg tancat!', 'primary')
    },
    cancel () {
      this.$snackbar.showError('Cancelat!')
    }
  }
}
</script>
