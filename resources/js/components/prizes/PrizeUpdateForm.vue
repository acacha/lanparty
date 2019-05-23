<template>
    <v-form>
        <v-text-field v-model="name" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" label="Nom" hint="El nom de la tasca..." placeholder="Nom de la tasca"></v-text-field>
        <v-text-field  v-model="description" @input="$v.description.$touch()" @blur="$v.description.$touch()" :error-messages="descriptionErrors" label="Descripció"></v-text-field >
        <v-text-field  v-model="notes" @input="$v.notes.$touch()" @blur="$v.notes.$touch()" :error-messages="noteErrors" label="Notes"></v-text-field >
        <v-text-field  v-model="value" @input="$v.value.$touch()" @blur="$v.value.$touch()" :error-messages="valueErrors" label="Valor"></v-text-field >
        <v-autocomplete  v-model="partner_id"  label="Patrocinador" :items="dataPartners" item-text="name" item-value="id"></v-autocomplete >
        <v-autocomplete  v-model="user_id" label="Usuari" :items="dataUsers" item-text="name" item-value="id"></v-autocomplete >
        <session-select
                v-model="session"
                :error-messages="sessionErrors"
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
        ></session-select>
        <v-text-field  v-model="number_id" label="Numero"></v-text-field >
        <v-checkbox v-model="multiple" label="Multiple"></v-checkbox>
        <div class="text-xs-center">
            <v-btn @click="$emit('close')">
                <v-icon class="mr-1">exit_to_app</v-icon>
                Cancel·lar
            </v-btn>
            <v-btn color="success" @click="update" :disabled="loading" :loading="loading">
                <v-icon class="mr-1" >save</v-icon>
                Actualitzar
            </v-btn>
        </div>
    </v-form>
</template>
<script>

import { validationMixin } from 'vuelidate'
import SessionSelect from '../SessionSelect'

import { required } from 'vuelidate/lib/validators'

export default {
  name: 'PrizeUpdateForm',
  mixins: [validationMixin],
  validations: {
    name: { required },
    description: { required },
    session: { required },
    value: { required },
    notes: { required },
  },
  components: {
    'session-select': SessionSelect
  },
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
      session: this.prize.session,
      loading: false,
      uploading: false,
      dataPartners: this.partners,
      dataUsers: this.users,
    }
  },
  props: {
    prize: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
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
    sessionErrors () {
      const errors = []
      if (!this.$v.session.$dirty) {
        return errors
      } else { !this.$v.session.required && errors.push('La sessió es obligatori.') }
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
    update () {
      this.loading = true
      const newPrize = {
        name: this.name,
        description: this.description,
        notes: this.notes,
        value: this.value,
        partner_id: this.partner_id,
        user_id: this.user_id,
        number_id: this.number_id,
        session: this.session,
        multiple: this.multiple,
      }
      window.axios.put(this.uri + this.prize.id, newPrize).then((response) => {
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
