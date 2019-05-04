<template>
    <span>
        <template v-if="confirming == number.id">
            <v-icon right v-if="!loading" @click="confirming = null" class="red--text darken-4--text">clear</v-icon>
            <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
            <v-icon right v-else @click="unassignNumber" class="green--text">done</v-icon>
        </template>
        <v-icon v-else right @click="confirming = number.id" color="pink">delete</v-icon>
    </span>
</template>

<script>
import * as actions from '../../store/action-types'
import * as mutations from '../../store/mutation-types'
import sleep from '../../utils/sleep'

export default {
  name: 'UnAssignNumberToUser',
  data () {
    return {
      loading: false,
      confirming: null,
      done: false
    }
  },
  props: {
    number: {
      type: Object,
      required: true
    }
  },
  methods: {
    unassignNumber () {
      this.loading = true
      this.$store.dispatch(actions.UNASSIGN_NUMBER_TO_USER, this.number).then(() => {
        this.done = true
        this.$store.commit(mutations.REMOVE_NUMBER_TO_SELECTED_USER_NUMBERS, this.number)
        this.loading = false
        sleep(1000).then(() => { this.loading = false; this.done = false, this.confirming = null })
      }).catch(() => {
        this.loading = false
        this.confirming = null
      })
    }
  }
}
</script>
