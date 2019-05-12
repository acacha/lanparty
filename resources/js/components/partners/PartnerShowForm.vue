<template>
  <v-form>
    <v-text-field
      autofocus
      v-model="name"
      label="Nom"
      hint="Nom del col·laborador"
      placeholder="Nom del col·laborador"
      readonly
    ></v-text-field>
    <v-text-field
      autofocus
      v-model="category"
      label="Categoria"
      hint="Categoria del col·laborador"
      placeholder="Categoria del col·laborador"
      readonly
    ></v-text-field>
    <v-text-field
      autofocus
      v-model="session"
      label="Sessió"
      hint="El nom del col·laborador"
      placeholder="Sessió del col·laborador"
      readonly
    ></v-text-field>

  </v-form>
</template>

<script>
export default {
  name: 'PartnerShowForm',
  data () {
    return {
      name: this.partner.name,
      category: this.partner.category,
      session: this.partner.session
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>

</style>
