<template>
<span>
     <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" transition="dialog-bottom-transition" @keydown.esc="dialog=false">
            <v-toolbar color="primary" class="white--text">
                <v-btn flat icon class="white--text" @click="dialog=false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title class="white--text mr-3">Editar premi</v-toolbar-title>
                <v-icon class="white--text">sentiment_satisfied_alt</v-icon>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="dialog=false">
                    <v-icon class="mr-2">exit_to_app</v-icon>
                    Sortir
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <prize-update-form :prize="prize" :uri="uri" :users="users" :partners="partners" @close="dialog=false" @updated="updated"></prize-update-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    <v-btn icon color="success" flat title="Actualitzar la premi" @click="dialog=true" >
        <v-icon>edit</v-icon>
     </v-btn>
</span>
</template>

<script>
import PrizeUpdateForm from './PrizeUpdateForm'
export default {
  name: 'PrizeUpdate',
  components: {
    'prize-update-form': PrizeUpdateForm
  },
  data () {
    return {
      dialog: false
    }
  },
  props: {
    prize: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true
    },
    partners: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  },
  methods: {
    updated (prize) {
      this.$emit('updated', prize)
    }
  }
}
</script>
