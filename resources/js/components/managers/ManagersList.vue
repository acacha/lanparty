<template>
    <v-data-table
            :headers="headers"
            :items="dataManagers"
            hide-actions
            item-key="name"
            expand
    >
        <template slot="items" slot-scope="props">
            <tr @click="expand($event, props)">
                <td class="text-xs-left" v-text="props.item.name"></td>
                <td class="text-xs-left" v-text="props.item.email"></td>
                <td class="text-xs-left" v-text="props.item.created_at"></td>
                <td class="text-xs-left" v-text="props.item.updated_at"></td>
                <td class="text-xs-right d-flex" >
                    TODO ACCIONS
                </td>
            </tr>
        </template>
    </v-data-table>
</template>

<script>
export default {
  name: 'ManagersList',
  data () {
    return {
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
  }
}
</script>
