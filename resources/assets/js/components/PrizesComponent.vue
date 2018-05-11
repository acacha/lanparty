<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="internalPrizes"
                hide-actions
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs">{{ props.item.partner.name }}</td>
                <td class="text-xs">{{ props.item.partner.category }}</td>
                <td class="text-xs">{{ priceInEuros(props.item.value) }}</td>
                <td class="text-xs-right">{{ props.item.number && props.item.number.value }}</td>
                <td class="text-xs-right">{{ winner(props.item) }}</td>
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
        internalPrizes: this.prizes,
        headers: [
          {
            text: 'Regal',
            align: 'left',
            value: 'name'
          },
          { text: 'Col·laborador', value: 'partner.name' },
          { text: 'Categoria', value: 'partner.category' },
          { text: 'Valorat', value: 'value' },
          { text: 'Número sorteig', value: 'number.value' },
          { text: 'Guanyador', value: 'winner' }
        ]
      }
    },
    props: {
      prizes: {
        type: Array,
        required: true
      }
    },
    methods: {
      priceInEuros (price) {
        if (price) {
          const value = parseInt(price) / 100
          return value + '€'
        }
      },
      winner (prize) {
        if (prize.user) return prize.user.name
        if (prize.number) {
          return prize.number.user.name
        }
        return ''
      }
    }
  }
</script>
