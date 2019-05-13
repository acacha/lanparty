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
    <v-flex
      xs12
      md4
    >
      <v-avatar
        slot="offset"
        class="mx-auto d-block"
        size="150"
      >
        <img ref="partner_avatar" src="https://3.bp.blogspot.com/-pxQONzCoagM/W_nddYu2U9I/AAAAAAAAJ3w/UD5KKwtzwnQwQy8a2DdFh2wFebsFOq5SACEwYBhgL/s1600/caa5a87b-16aa-4712-9d50-479919cb94.png">
      </v-avatar>
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
