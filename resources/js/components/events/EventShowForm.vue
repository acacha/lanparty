<template>
  <v-form>
    <v-text-field v-model="name" label="Nom" hint="Nom de la tasca"
                  readonly></v-text-field>

    <v-text-field v-model="inscription_type_id" label="Tipus de inscripció" hint="Tipus de inscripció"
                  readonly></v-text-field>

    <v-text-field v-model="participants_number" label="Número de participants" hint="Número de participants"
                  readonly></v-text-field>

    <v-text-field v-model="regulation" label="URL del Reglament" hint="URL del Reglament"
                  readonly></v-text-field>

    <v-text-field v-model="session" label="Session" hint="Session"
                  readonly></v-text-field>

    <div class="text-xs-center">
      <v-btn @click="$emit('close')">
        <v-icon class="mr-2">exit_to_app</v-icon>
        Sortir
      </v-btn>
    </div>
  </v-form>
</template>

<script>

export default {
  'name': 'EventShowForm',
  data () {
    return {
      name: this.event.name,
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
  }
}
</script>
