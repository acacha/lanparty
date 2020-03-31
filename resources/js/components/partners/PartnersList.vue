<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <span>
      <v-flex xs12 justify-center>
          <v-toolbar color="primary ligthen-2">
            <v-toolbar-title class="white--text">Col·laboradors</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
              <v-icon>refresh</v-icon>
            </v-btn>
      </v-toolbar>
        <v-card>
          <v-card-title>
            <v-layout row wrap>
              <v-flex>
                <v-text-field
                  append-icon="search"
                  label="Buscar"
                  v-model="search"
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="dataPartners"
            :search="search"
            no-results-text="No s'ha trobat cap registre"
            no-data-text="No hi ha dades disponibles"
            rows-per-page-text="Col·laboradors per pàgina"
            :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
            :loading="loading"
            :pagination.sync="pagination"
            class="hidden-md-and-down"
          >
            <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
            <template
              slot="items"
              slot-scope="{item: partner}"
            >
              <tr>
                <td>{{partner.id}}</td>
                <td>
                  <partner-edit-name-inline :partner="partner" :uri="uri" @change="refresh(false)"></partner-edit-name-inline>
                </td>
                <td>{{partner.category}}</td>
                <td>
                    <partner-avatar :partner="partner" @change="refresh(false)"></partner-avatar>
                </td>
                <td>{{partner.session}}</td>
                <td>
                  <li v-for="prize in partner.prizes">
                    {{prize.name}}
                  </li>
                </td>
                <td><span :title="partner.formatted_created_at">{{ partner.formatted_created_at_diff}}</span></td>
                <td><span :title="partner.formatted_updated_at">{{ partner.formatted_updated_at_diff }}</span></td>
                <td>
                  <partner-show :partner="partner"></partner-show>
                  <partner-update :partner="partner" @updated="updatePartner" :uri="uri"></partner-update>
                  <partner-destroy :partner="partner" @removed="removePartner" :uri="uri"></partner-destroy>
                </td>
              </tr>
            </template>
          </v-data-table>
        </v-card>
        </v-flex>
    </span>
</template>

<script>
import PartnerShow from './PartnerShow'
import PartnerDestroy from './PartnerDestroy'
import PartnerUpdate from './PartnerUpdate'
import PartnerAvatar from './PartnerAvatar'
import PartnerEditNameInline from './PartnerEditNameInline'

export default {
  name: 'PartnersList',
  components: {
    'partner-show': PartnerShow,
    'partner-update': PartnerUpdate,
    'partner-destroy': PartnerDestroy,
    'partner-avatar': PartnerAvatar,
    'partner-edit-name-inline': PartnerEditNameInline
  },
  data () {
    return {

      loading: false,
      dataPartners: this.partners,
      search: '',
      headers: [
        { text: 'ID', value: 'id' },
        { text: 'NOM', value: 'name' },
        { text: 'CATEGORIA', value: 'category' },
        { text: 'AVATAR', value: 'avatar' },
        { text: 'SESSION', value: 'session' },
        { text: 'PREMIS', value: 'prizes' },
        { text: 'CREAT', value: 'created_at_timestamp' },
        { text: 'MODIFICAT', value: 'updated_at_timestamp' },
        { text: 'ACCIONS', sortable: false, value: 'ful1l_search' }
      ],
      pagination: {
        rowsPerPage: 25
      }
    }
  },
  props: {
    partners: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  watch: {
    partners (newPartner) {
      this.dataPartners = newPartner
    }
  },
  computed: {
    total () {
      return this.dataPartners.length
    }
  },
  methods: {
    removePartner (partner) {
      this.dataPartners.splice(this.dataPartners.indexOf(partner), 1)
    },
    updatePartner (partner) {
      this.refresh()
    },
    refresh (message = true) {
      this.loading = true
      window.axios.get(this.uri).then(response => {
        this.dataPartners = response.data
        this.loading = false
        if (message) this.$snackbar.showMessage('Partners actualizats correctament')
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
