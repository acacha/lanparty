<template>
    <v-form>
        <v-text-field v-model="name" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" label="Nom" hint="El nom de la tasca..." placeholder="Nom de la tasca"></v-text-field>
        <v-text-field  v-model="description" @input="$v.description.$touch()" @blur="$v.description.$touch()" label="Descripció"></v-text-field >
        <v-text-field  v-model="notes" @input="$v.notes.$touch()" @blur="$v.notes.$touch()" label="Notes"></v-text-field >
        <v-text-field  v-model="value" @input="$v.value.$touch()" @blur="$v.value.$touch()" label="Valor"></v-text-field >
        <v-text-field  v-model="partner_id" @input="$v.partner_id.$touch()" @blur="$v.partner_id.$touch()" label="Patrocinador"></v-text-field >
        <v-text-field  v-model="user_id" @input="$v.user_id.$touch()" @blur="$v.user_id.$touch()" label="Usuari"></v-text-field >
        <v-text-field  v-model="number_id" @input="$v.number_id.$touch()" @blur="$v.number_id.$touch()" label="Numero"></v-text-field >
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
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'PrizeUpdateForm',
  mixins: [validationMixin],
  validations: {
    name: { required },
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
      loading: false,
      uploading: false
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
    }
  },
  computed: {
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) {
          return errors
        } else { !this.$v.name.required && errors.push('El nom es obligatori.') }
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
