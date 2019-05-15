<template>
    <v-tooltip bottom v-if="event.deleted_at">
        <v-btn slot="activator" icon class="mx-0" @click="archive" :loading="unarchiving" :disabled="unarchiving">
            <v-icon color="primary">unarchive</v-icon>
        </v-btn>
        <span>Activar l'event</span>
    </v-tooltip>
</template>

<script>
  export default {
    name: 'EventUnarchive',
    data () {
      return {
        unarchiving: false
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
        let res = await this.$confirm('Esteu segurs que voleu activar aquest esdeveniment?', { title: 'Esteu segurs?', buttonTrueText: 'Activar' })
        if (res) {
          this.archiveEvent()
        }
      },
      archiveEvent () {
        this.unarchiving = true
        window.axios.delete('/api/v1/archived_events/' + this.event.id).then(() => {
          this.unarchiving = false
          this.$snackbar.showMessage('Esdeveniment activat correctament')
          this.$emit('unarchived')
        }).catch(() => {
          this.unarchiving = false
        })
      }
    }
  }
</script>
