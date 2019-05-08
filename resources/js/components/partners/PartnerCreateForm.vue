<template>
  <v-form>
    <v-text-field
      autofocus
      v-model="name"
      label="Nom"
      hint="Nom del col·laborador"
      :error-messages="nameErrors"
      @input="$v.name.$touch()"
      @blur="$v.name.$touch()"
    ></v-text-field>

    <v-combobox
      autofocus
      v-model="category"
      :items="itemsCategory"
      label="Categoria"
      hint="Tria una categoria"
      :error-messages="categoryErrors"
      @input="$v.name.$touch()"
      @blur="$v.name.$touch()"
    ></v-combobox>

    <session-select></session-select>

    <div class="text-xs-center">
      <v-btn @click="$emit('close')">
        <v-icon class="mr-1">exit_to_app</v-icon>
        CANCEL·LAR
      </v-btn>
      <v-btn color="success" @click="add" :disabled="loading || $v.$invalid" :loading="loading">
        <v-icon class="mr-1" >save</v-icon>
        AFEGIR
      </v-btn>
    </div>
  </v-form>

</template>

<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
import SessionSelect from '../SessionSelect'

export default {
  mixins: [validationMixin],
  validations: {
    name: { required },
    category: { required }
  },
  name: 'PartnerCreateForm',
  components: {
    'session-select': SessionSelect
  },
  data () {
    return {
      name: '',
      category: '',
      itemsCategory:
      [
        'Or',
        'Plata',
        'Bronze'
      ],
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
    categoryErrors () {
      const errors = []
      if (!this.$v.category.$dirty) {
        return errors
      } else { !this.$v.category.required && errors.push('La categoria es obligatoria.') }
      return errors
    }
  },
  methods: {
    reset () {
      this.name = ''
      this.category = ''
    },
    add () {
      this.loading = true
      const partner = {
        'name': this.name,
        'category': this.category
      }
      window.axios.post(this.uri, partner).then(response => {
        this.$snackbar.showMessage('Col·laborador creat correctament')
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
