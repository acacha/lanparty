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
    }
  },
  methods: {
    async remove () {
      let res = await this.$confirm('Els premis esborrats no es poden recuperar',
        {
          title: 'Elimnar premi ?',
          buttonTruetext: 'Eliminar',
          buttonFalsetext: 'Cancel·lar',
          color: 'error darken-1'
        }
        )
      if (res) {
        this.removePrizes()
      }
    },
    removePrizes () {
      this.deleting = true
      console.log(this.prize.id)
      window.axios.delete('/api/v1/prizes/' + prize.id).then(() => {
        this.$emit('deleted', task)
        this.deleting = false
        this.$snackbar.showMessage('Premi eliminat correctament')
      }).catch(() => {
        this.deleting = false
      })
    }
  }
}
</script>
