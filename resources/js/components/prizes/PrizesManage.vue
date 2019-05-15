<template>
    <v-container grid-list-md text-xs-center fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <prizes-list :uri="uri" :prizes="prizes"></prizes-list>
                <prizes-create :uri="uri" @created="add"></prizes-create>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
  import PrizesList from './PrizesList'
  import PrizesCreate from './PrizesCreate'
  export default {
    name: 'PrizesManage',
    data () {
      return {
        dataPrizes: this.prizes,
      }
    },
    components: {
      'prizes-list': PrizesList,
      'prizes-create': PrizesCreate
    },
    props: {
      prizes: {
        type: Array,
        required: true
      },
      uri: {
        type: String,
        required: true
      }
    },
    methods: {
      add (prize) {
        this.dataPrizes.push(prize)
      }
    }
  }

</script>
