<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <v-btn icon slot="activator">
            <v-icon class="white--text">delete</v-icon>
        </v-btn>
        <v-card>
            <v-card-title class="headline">Si us plau confirmeu</v-card-title>
            <v-card-text>
                Segur que voleu esborrar tots els premis assignats?
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click.native="dialog = false">Cancel·lar</v-btn>
                <v-btn color="error darken-1" flat
                       :disabled="loading"
                       :loading="loading"
                       @click.native="removeAllWinners">Eliminar tots</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
  name: 'RemoveAllWinners',
  data () {
    return {
      loading: false,
      dialog: false
    }
  },
  props: {
    session: {
      type: String,
      required: true
    }
  },
  methods: {
    removeAllWinners () {
      this.loading = true
      window.axios.delete('/api/v1/' + this.session + '/winners').then(() => {
        this.loading = false
        this.dialog = false
        this.$snackbar.showMessage('Tots els guanyadors eliminats correctament')
        this.$emit('removedAll')
      }).catch(() => {
        this.loading = false
      })
    }
  },
}
</script>
