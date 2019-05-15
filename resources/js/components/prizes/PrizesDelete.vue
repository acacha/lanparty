<template>
    <v-tooltip bottom>
        <v-btn slot="activator" icon class="mx-0" @click="remove(prize)" :loading="deleting" :disabled="deleting">
            <v-icon color="error">delete</v-icon>
        </v-btn>
        <span>Eliminar Premi</span>
    </v-tooltip>
</template>

<script>
export default {
  name: 'PrizesDelete',
  data () {
    return {
      deleting: false
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
    }
  },
  methods: {
    async remove (prize) {
      let result = await this.$confirm('Els premis esborrats no es poden recuperar',
        {
          title: 'Elimnar premi ?',
          buttonTruetext: 'Eliminar',
          buttonFalsetext: 'Cancel·lar',
          color: 'error darken-1'
        })
      if (result) {
        this.deleting = true
        window.axios.delete(this.uri + prize.id).then(() => {
          this.$emit('deleted', prize)
          this.deleting = false
          this.$snackbar.showMessage('Premi eliminat correctament')
        }).catch(() => {
          this.deleting = false
        })
      }
    }
  }
}
</script>
