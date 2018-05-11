<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="internalPartners"
                hide-actions
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.category }}</td>
                <td>{{ showPrizes(props.item.prizes) }}</td>
            </template>
        </v-data-table>
    </div>
</template>

<style>

</style>

<script>
  export default {
    data () {
      return {
        internalPartners: this.partners,
        headers: [
          { text: 'Col·laborador', value: 'name' },
          { text: 'Categoria', value: 'category' },
          { text: 'Premis', value: 'prizes' }
        ]
      }
    },
    props: {
      partners: {
        type: Array,
        required: true
      }
    },
    methods: {
      showPrizes (prizes) {
        return prizes.map(prize => prize.name).join(', ')
      }
    }
  }
</script>
