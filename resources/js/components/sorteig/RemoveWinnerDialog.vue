<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <v-icon slot="activator" color="red" >delete</v-icon>
        <v-card>
            <v-card-title class="headline">Si us plau confirmeu</v-card-title>
            <v-card-text>
                Segur que voleu esborrar l'assignació del premi?
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" flat @click.native="dialog = false">Cancel·lar</v-btn>
                <v-btn color="error darken-1" flat
                       :disabled="removing"
                       :loading="removing"
                       @click.native="remove()">Eliminar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
  name: 'RemoveWinnerDialog',
  data () {
    return {
      dialog: false,
      removing:false
    }
  },
  props: {
    winner: {
      type: Object,
      required: true
    }
  },
  methods: {
    remove () {
      this.removing = true
      window.axios.delete('/api/v1/winner/' + this.winner.id).then(response => {
        this.$emit('removed')
        this.removing = false
        this.dialog = false
      }).catch(() => {
        this.removing = false
      })
    }
  }
}
</script>
