<template>
  <v-btn
    v-can="'partners.destroy'"
    icon
    color="error"
    flat
    title="Eliminar col·laborador"
    :loading="removing"
    :disabled="removing"
    @click="destroy(partner)"
  ><v-icon>delete</v-icon></v-btn>
</template>

<script>
export default {
  name: 'PartnerDestroy',
  data () {
    return {
      removing: false
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    async destroy (partner) {
      let result = await this.$confirm('Els col·laborador esborrats ja no es pot recuperar',
        {
          title: 'Està segur?',
          buttonTrueText: 'Eliminar',
          buttonFalseText: 'Cancel·lar',
          color: 'error'
        })
      if (result) {
        this.removing = true
        window.axios.delete(this.uri + partner.id).then(() => {
          this.$snackbar.showMessage("S'ha esborrat correctament")
          this.$emit('removed', partner)
          this.removing = false
        }).catch(() => {
          this.removing = false
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
