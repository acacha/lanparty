<template>
    <span>
        <v-dialog v-model="dialog" max-width="600px">
                    <v-card>
                        <v-toolbar dark color="pink">
                            <v-icon>card_giftcard</v-icon>
                            <v-toolbar-title>NOU PREMI</v-toolbar-title>
                        </v-toolbar>
                        <v-spacer></v-spacer>
                        <v-card-text>
                          <prize-create-form :uri="uri" @close="dialog =false" @created="created"></prize-create-form>
                        </v-card-text>

                    </v-card>
                </v-dialog>
           <v-btn
                   v-can="'prizes.store'"
                   @click="dialog = true"
                   fab
                   bottom
                   right
                   fixed
                   large
                   color="pink"
                   class="white--text"
                  >
                  <v-icon>add</v-icon>
         </v-btn>
    </span>
</template>

<script>
  import PrizesCreateForm from './PrizesCreateForm'

  export default {
    name: 'PrizesCreate',
    components: {
      'prize-create-form': PrizesCreateForm
    },
    data () {
      return {
        dialog: false
      }
    },
    props: {
      uri: {
        type: String,
        required: true
      }
    },
    methods: {
      created (prize) {
        this.$emit('created', prize)
      }
    }
  }
</script>
