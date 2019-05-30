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
          v-model="name"
          :error-messages="nameErrors"
          @input="$v.name.$touch()"
          @blur="$v.name.$touch()"
        ></v-text-field>
        <v-combobox
          v-model="category"
          :items="itemsCategory"
        ></v-combobox>
        <session-select
          v-model="session"
          :error-messages="sessionErrors"
          @input="$v.name.$touch()"
          @blur="$v.name.$touch()"
        ></session-select>
        </v-flex>
      </v-layout>
    </v-container>
    <div class="text-xs-center">
      <v-btn @click="$emit('close')">
        <v-icon class="mr-1">exit_to_app</v-icon>
        Cancel·lar
      </v-btn>
      <v-btn color="success" @click="update" :disabled="loading" :loading="loading">
        <v-icon class="mr-1">save</v-icon>
        Modificar
      </v-btn>
    </div>
  </v-form>
</template>

<script>
import SessionSelect from '../SessionSelect'
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
import PartnerAvatar from './PartnerAvatar'

export default {
  mixins: [validationMixin],
  validations: {
    name: { required },
    session: { required }
  },
  name: 'PartnerUpdateForm',
  components: {
    'session-select': SessionSelect,
    'partner-avatar': PartnerAvatar
  },
  data () {
    return {
      name: this.partner.name,
      category: this.partner.category,
      itemsCategory:
        [
          'Or',
          'Plata',
          'Bronze'
        ],
      session: this.partner.session,
      loading: false,
      uploading: false
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
    update () {
      this.loading = true
      const newPartner = {
        name: this.name,
        category: this.category,
        session: this.session
      }
      window.axios.put(this.uri + this.partner.id, newPartner).then((response) => {
        this.$emit('updated', response.data)
        this.$emit('close')
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
