<template>
  <v-form>
    <v-container
      fill-height
      fluid
      grid-list-xl
    >
      <v-layout
      justify-center
      wrap
      >
    <v-flex
      xs12
      md8>
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
    </v-flex>
      </v-layout>
    </v-container>
  </v-form>
</template>

<script>
export default {
  name: 'PartnerShowForm',
  data () {
    return {
      name: this.partner.name,
      category: this.partner.category,
      session: this.partner.session,
      avatar: this.partner.avatar
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
