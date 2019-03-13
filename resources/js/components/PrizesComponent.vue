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
                <td class="text-xs">{{ props.item.number && props.item.number.value }}</td>
                <td class="text-xs">{{ winner(props.item) }}</td>
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
      name (winner) {
        let name = ''
        if (!winner) return name
        if (winner.sn1) name = name + winner.sn1
        if (winner.sn2) name = name + ' ' + winner.sn2
        if (winner.name) {
          if (name) {
            name = name + ', ' + winner.givenName
          } else {
            name = name + winner.givenName
          }
        }
        return name
      },
      winner (prize) {
        if (prize.user) return prize.user.name + ' (' + this.name(prize.user) + ')'
        if (prize.number) {
          return prize.number.user.name + ' (' + this.name(prize.number.user) + ')'
        }
        // 9999 user id is a fake user -> prizes preassigned to competition winners
        if (prize.user_id) return prize.notes
        return ''
      }
    }
  }
</script>
