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
          md8
        >
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
    ></v-combobox>

    <session-select
      v-model="session"
      :error-messages="sessionErrors"
      @input="$v.name.$touch()"
      @blur="$v.name.$touch()"
    ></session-select>
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
            <img ref="partner_avatar"
                 src="https://3.bp.blogspot.com/-pxQONzCoagM/W_nddYu2U9I/AAAAAAAAJ3w/UD5KKwtzwnQwQy8a2DdFh2wFebsFOq5SACEwYBhgL/s1600/caa5a87b-16aa-4712-9d50-479919cb94.png"
            >
          </v-avatar>
        </v-flex>
      </v-layout>
    </v-container>
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
    session: { required }
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
      session: '',
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
    sessionErrors () {
      const errors = []
      if (!this.$v.session.$dirty) {
        return errors
      } else { !this.$v.session.required && errors.push('La sessió es obligatori.') }
      return errors
    }
  },
  methods: {
    reset () {
      this.name = ''
      this.category = ''
      this.session = ''
    },
    add () {
      this.loading = true
      const partner = {
        'name': this.name,
        'category': this.category,
        'session': this.session
      }
      window.axios.post(this.uri, partner).then(response => {
        this.$snackbar.showMessage('Col·laborador creat correctament')
        this.reset()
        console.log(partner.session)
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
