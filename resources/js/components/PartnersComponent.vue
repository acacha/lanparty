<template>
    <v-container grid-list-md text-xs-center fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <v-toolbar  dark color="green light">
                    <v-icon style="margin-right: 1%">card_giftcard</v-icon>
                    <v-icon>contacts</v-icon>
                    <v-toolbar-title>Col·laboradors</v-toolbar-title>
                </v-toolbar>
                <v-data-table
                        :headers="headers"
                        :items="internalPartners"
                        hide-actions
                        class="elevation-1"
                >
                    <template slot="items" slot-scope="props">
                        <td>
                            <v-img :src="props.item.avatar" :alt="props.item.name" :contain="true" min-width="500px" max-height="120px"></v-img>
                        </td>
                        <td min-width="100px">{{ showPrizes(props.item.prizes) }}</td>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<style>
.partner-name {
  min-width: 100px;
}
</style>

<script>
  export default {
    name: 'Partners',
    data () {
      return {
        internalPartners: this.partners,
        headers: [
          { text: 'Col·laborador', value: 'avatar', class: 'partner-logo' },
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
