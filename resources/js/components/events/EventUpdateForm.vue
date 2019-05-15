<template>
  <v-form>
    <v-text-field autofocus v-model="name" label="Nom" hint="Nom de l'esdeveniment"
                  placeholder="Nom de l'esdeveniment"></v-text-field>

    <v-text-field v-model="inscription_type_id" label="Tipus de inscripció" hint="Tipus de inscripció"
                  placeholder="Tipus de inscripció"></v-text-field>

    <v-text-field v-model="participants_number" label="Número de participants" hint="Número de participants"
                  placeholder="Número de participants"></v-text-field>

    <v-text-field v-model="regulation" label="URL del Reglament" hint="URL del Reglament"
                  placeholder="URL del Reglament"></v-text-field>

    <session-select v-model="session"></session-select>

    <div class="text-xs-center">
      <v-btn @click="$emit('close')">
        <v-icon class="mr-1">exit_to_app</v-icon>
        Cancel·lar
      </v-btn>
      <v-btn color="success" @click="update" :disabled="working || $v.$invalid" :loading="working">
        <v-icon class="mr-1">save</v-icon>
        Guardar
      </v-btn>
    </div>
  </v-form>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
import SessionSelect from '../SessionSelect.vue'

export default {
  'name': 'EventUpdateForm',
  components: {
    'SessionSelect': SessionSelect
  },
  mixins: [validationMixin],
  validations: {
    name: { required }
  },
  data () {
    return {
      name: this.event.name,
      image: this.event.image,
      inscription_type_id: this.event.inscription_type_id,
      participants_number: this.event.participants_number,
      regulation: this.event.regulation,
      session: this.event.session,
      working: false
    }
  },
  props: {
    event: {
      type: Object,
      required: true
    }
  },
  methods: {
    update () {
      this.working = true
      window.axios.put('/api/v1/events/' + this.event.id,
        {
          name: this.name,
          image: this.image,
          inscription_type_id: this.inscription_type_id,
          participants_number: this.participants_number,
          regulation: this.regulation,
          session: this.session
        }
      ).then((response) => {
        this.$emit('updated', response.data)
        this.$emit('close')
        this.working = false
        this.$snackbar.showMessage("S'ha actualitzat correctament")
      }).catch(error => {
        this.working = false
      })
    }
  }
}
</script>
