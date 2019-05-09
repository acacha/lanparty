<template>
    <v-container grid-list-md text-xs-center fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <v-toolbar  dark color="green light">
                    <v-icon style="margin-right: 1%">card_giftcard</v-icon>
                    <v-icon>favorite_border</v-icon>
                    <v-toolbar-title>Premis</v-toolbar-title>
                </v-toolbar>
                <v-data-table
                        :headers="headers"
                        :items="internalPrizes"
                        hide-actions
                        class="elevation-1"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs" align="left">{{ props.item.name }}</td>
                        <td class="text-xs" align="left">{{ props.item.partner.name }}</td>
                        <td class="text-xs">{{ priceInEuros(props.item.value) }}</td>
                        <td class="text-xs">{{ winner(props.item) }}</td>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<style>

</style>

<script>
  import helpers from '../utils/helpers'

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
          { text: 'Valorat', value: 'value' },
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
        return helpers.priceInEuros(price)
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
