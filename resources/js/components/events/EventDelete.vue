<template>
    <v-tooltip bottom>
        <v-btn slot="activator" icon class="mx-0" @click="remove" :loading="deleting" :disabled="deleting">
            <v-icon color="error">delete</v-icon>
        </v-btn>
        <span>Eliminar permanentment l'esdeveniment</span>
    </v-tooltip>
</template>

<script>
export default {
  name: 'EventDelete',
  data () {
    return {
      deleting: false
    }
  },
  props: {
    event: {
      type: Object,
      required: true
    }
  },
  methods: {
    async remove () {
      let res = await this.$confirm('Esteu segurs que voleu eliminar aquest esdeveniment?', { title: 'Esteu segurs?', buttonTrueText: 'Eliminar' })
      if (res) {
        this.removeEvent()
      }
    },
    removeEvent () {
      this.deleting = true
      window.axios.delete('/api/v1/events/' + this.event.id).then(() => {
        this.deleting = false
        this.$snackbar.showMessage('Esdeveniment eliminat correctament')
      }).catch(() => {
        this.deleting = false
      })
    }
  }
}
</script>
