<template>
    <v-form>
        <v-text-field v-model="name" label="Nom" hint="El nom de la tasca..." placeholder="Nom de la tasca"></v-text-field>
        <v-text-field  v-model="description" label="Descripció"></v-text-field >
        <v-text-field  v-model="notes" label="Notes"></v-text-field >
        <v-text-field  v-model="value" label="Valor"></v-text-field >
        <v-text-field  v-model="partner_id" label="Patrocinador"></v-text-field >
        <v-text-field  v-model="user_id" label="Usuari"></v-text-field >
        <v-text-field  v-model="number_id" label="Numero"></v-text-field >
        <v-checkbox v-model="multiple" label="Multiple"></v-checkbox>
        <div class="text-xs-center">
            <v-btn @click="$emit('close')">
                <v-icon class="mr-1">exit_to_app</v-icon>
                Cancel·lar
            </v-btn>
            <v-btn color="success" @click="update">
                <v-icon class="mr-1" >save</v-icon>
                Actualitzar
            </v-btn>
        </div>
    </v-form>
</template>
<script>

export default {
  name: 'PrizeUpdateForm',
  // validations: {
  //   name: { required }
  // },
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
    }
  },
  props: {
    prize: {
      type: Object,
      required: true
    }
  },
  // watch: {
  //   prize (prize) {
  //     this.updateUser(prize)
  //   }
  // },
  methods: {
    // updateUser (prize) {
    //   this.user = this.users.find((user) => {
    //     return parseInt(user.id) === parseInt(prize.user_id)
    //   })
    // },
    update () {
      this.working = true
      const newTask = {
        name: this.name,
        description: this.description,
        completed: this.completed,
        user_id: this.user.id
      }
      window.axios.put(this.uri + '/' + this.prize.id, newTask).then((response) => {
        this.$emit('updated', response.data)
        this.$emit('close')
        this.working = false
      }).catch(error => {
        this.working = false
      })
    }
  }
}
</script>
