<template>
  <v-form>
    <v-container grid-list-md>
      <v-layout wrap>
        <v-flex xs12>
          <v-text-field prepend-icon="videogame_asset" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" v-model="name" label="Nom"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="description" :error-messages="descriptionErrors" @input="$v.description.$touch()" @blur="$v.description.$touch()" v-model="description" label="Descripcio"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="event_note" :error-messages="noteErrors" @input="$v.notes.$touch()" @blur="$v.notes.$touch()" v-model="notes" label="Notes"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="poll" :error-messages="valueErrors" @input="$v.value.$touch()" @blur="$v.value.$touch()" v-model="value" label="Valor"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="devices_other" v-model="partner_id" label="patrocinador"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="account_circle" v-model="user_id" label="Usuari"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-text-field prepend-icon="filter_9_plus" v-model="number_id" label="Numero"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-checkbox v-model="multiple" label="Multiple"></v-checkbox>
        </v-flex>
      </v-layout>
    </v-container>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn @click="$emit('close')">
        <v-icon class="mr-2">exit_to_app</v-icon>
        Close</v-btn>
      <v-btn color="success" @click="add" :disabled="loading || $v.$invalid" :loading="loading">
        <v-icon class="mr-2">save</v-icon>
        Guardar</v-btn>
    </v-card-actions>
  </v-form>

</template>

<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'

export default {
  mixins: [validationMixin],
  validations: {
    name: { required },
    description: { required },
    value: { required },
    notes: { required },
  },
  name: 'PrizesCreateForm',
  data () {
    return {
      dialog: false,
      name: '',
      description: '',
      notes: '',
      value:'',
      partner_id:'',
      user_id:'',
      number_id:'',
      multiple: false,
      loading: false
    }
  },
  props: {
    uri: {
      type: String,
      required: true
    }
  },
  computed: {
    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) {
        return errors
      } else { !this.$v.name.required && errors.push('El nom es obligatori.') }
      return errors
    },
    descriptionErrors () {
      const errors = []
      if (!this.$v.description.$dirty) {
        return errors
      } else { !this.$v.description.required && errors.push('El camp description es obligatori.') }
      return errors
    },
    noteErrors () {
      const errors = []
      if (!this.$v.notes.$dirty) {
        return errors
      } else { !this.$v.notes.required && errors.push('El camp nota es obligatori.') }
      return errors
    },
    valueErrors () {
      const errors = []
      if (!this.$v.value.$dirty) {
        return errors
      } else { !this.$v.value.required && errors.push('El camp valor es obligatori.') }
      return errors
    }
  },
  methods: {
    reset () {
      this.name = ''
      this.description = ''
      this.notes = ''
      this.value = ''
      this.partner_id = null
      this.user_id = null
      this.number_id = ''
      this.multiple = false
    },
    add () {
      this.loading = true
      const prize = {
        'name': this.name,
        'description': this.description,
        'notes': this.notes,
        'value': this.value,
        'partner_id': this.partner_id,
        'user_id': this.user_id,
        'number_id': this.number_id,
        'multiple': this.multiple
      }
      window.axios.post(this.uri + '/', prize).then((response) => {
        this.$snackbar.showMessage("S'ha creat correctament el premi")
        this.reset()
        this.$emit('created', response.data)
        this.loading = false
        this.$emit('close')
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
