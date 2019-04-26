<template>
    <v-tooltip bottom>
        <v-btn slot="activator" icon class="mx-0" @click="archive" :loading="archiving" :disabled="archiving">
            <v-icon color="warning">archive</v-icon>
        </v-btn>
        <span>Archivar (esborrat lògic) de l'event</span>
    </v-tooltip>
</template>

<script>
  export default {
    name: 'EventArchive',
    data () {
      return {
        archiving: false
      }
    },
    props: {
      event: {
        type: Object,
        required: true
      }
    },
    methods: {
      async archive () {
        let res = await this.$confirm('Esteu segurs que voleu archivar aquest event?', { title: 'Esteu segurs?', buttonTrueText: 'Eliminar' })
        if (res) {
          this.archiveEvent()
        }
      },
      archiveEvent () {
        this.archiving = true
        window.axios.post('/api/v1/archived_events/' + this.event.id).then(() => {
          this.archiving = false
          this.$snackbar.showMessage('Event archivat correctament')
        }).catch(() => {
          this.archiving = false
        })
      }
    }
  }
</script>
