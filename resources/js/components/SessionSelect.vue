<template>
    <v-select
            v-model="dataSession"
            :items="sessions"
            label="Escolliu una sessió"
    ></v-select>
</template>

<script>
export default {
  name: 'SessionSelect',
  data () {
    return {
      dataSession: this.session
    }
  },
  model: {
    prop: 'session',
    event: 'input'
  },
  props: {
    session: {
      Type: String,
      required: true
    }
  },
  watch: {
    dataSession (dataSession) {
      this.$emit('input', dataSession)
    },
    session (session) {
      this.dataSession = session
    }
  },
  created () {
    this.sessions = window.lanparty.sessions.map(session => session.name)
  }
}
</script>
