<template>
  <v-form>
    <v-text-field autofocus readonly v-model="name" label="Nom" placeholder="Nom de la tasca" hint="Nom del Premi"></v-text-field>
    <v-text-field  autofocus readonly v-model="description" label="Descripció" placeholder="Nom de la Descripció" hint="Nom de la Descripció" ></v-text-field >
    <v-text-field autofocus readonly v-model="notes" label="Nota" placeholder="Nom de la Nota" hint="Nom de la Nota" ></v-text-field >
    <v-text-field autofocus readonly v-model="value" label="Valor" placeholder="Nom del Valor" hint="Nom del Valor" ></v-text-field >
    <v-autocomplete autofocus readonly v-model="partner_id"  label="Patrocinador" :items="dataPartners" item-text="name" item-value="id"></v-autocomplete >
    <v-autocomplete autofocus readonly v-model="user_id"  label="Usuaris" :items="dataUsers" item-text="name" item-value="id"></v-autocomplete >
    <v-text-field autofocus readonly v-model="number_id" label="Numero" placeholder="Numero sorteig" hint="Numero sorteig"></v-text-field >
    <v-checkbox autofocus readonly v-model="multiple" label="Multiple" placeholder="Multiple" hint="Es multiple o no" ></v-checkbox>
  </v-form>
</template>

<script>
export default {
  name: 'PartnerShowForm',
  data () {
    return {
      name: this.prize.name,
      description: this.prize.description,
      notes: this.prize.notes,
      value: this.prize.value,
      partner_id: this.prize.partner_id,
      user_id: this.prize.user_id,
      number_id: this.prize.number_id,
      multiple: this.prize.multiple,
      dataPartners: this.partners,
      dataUsers: this.users
    }
  },
  props: {
    prize: {
      type: Object,
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
  }
}
</script>

<style scoped>

</style>
