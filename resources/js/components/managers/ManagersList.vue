<template>
    <span>
        <v-toolbar color="primary" dense>
            <v-toolbar-title class="white--text">Managers</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon class="white--text" :loading="loading" :disabled="loading" @click="refresh">
                <v-icon>refresh</v-icon>
            </v-btn>
        </v-toolbar>
        <v-data-table
                :headers="headers"
                :items="dataManagers"
                hide-actions
                item-key="name"
                expand
        >
        <template slot="items" slot-scope="props">
            <tr>
                <td class="text-xs-left" v-text="props.item.name"></td>
                <td class="text-xs-left" v-text="props.item.email"></td>
                <td class="text-xs-left" v-text="props.item.created_at"></td>
                <td class="text-xs-left" v-text="props.item.updated_at"></td>
                <td class="text-xs-right d-flex" >
                    <manager-delete @deleted="refresh" :manager="props.item"></manager-delete>
                </td>
            </tr>
        </template>
    </v-data-table>
    </span>

</template>

<script>
import ManagerDelete from './ManagerDelete'
export default {
  name: 'ManagersList',
  components: {
    'manager-delete': ManagerDelete
  },
  data () {
    return {
      loading: false,
      dataManagers: this.managers,
      headers: [
        { text: 'Nom', align: 'left', value: 'name' },
        { text: 'Correu electrònic', value: 'email' },
        { text: 'Data creació', value: 'created_at' },
        { text: 'Data modificació', value: 'updated_at' },
        { text: 'Accions', value: 'full_search' },
      ]
    }
  },
  props: {
    managers: {
      type: Array,
      required: true,
    }
  },
  methods: {
    refresh () {
      this.loading= true
      window.axios('/api/v1/managers').then(response => {
        this.dataManagers = response.data
        this.loading= false
        this.$snackbar.showMessage('Managers actualitzats correctament');
      }).catch(() => {
        this.loading= false
      })
    }
  }
}
</script>
