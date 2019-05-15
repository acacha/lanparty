<template>
    <v-select
            v-model="dataSession"
            :items="sessions"
            label="Escolliu una sessió"
            :chips="chips"
            :clearable="true"
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
    session: {},
    chips: {
      type: Boolean,
      default: false
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
