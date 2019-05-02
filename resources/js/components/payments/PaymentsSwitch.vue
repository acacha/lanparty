<template>
    <v-switch
            label="Pagat"
            :input-value="inscriptionPaid"
            @change="togglePayment(selectedUser)"
            :loading="loading"
            :disabled="loading"
    ></v-switch>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../../store/action-types'

export default {
  name: 'PaymentsSwitch',
  data () {
    return {
      loading: false
    }
  },
  props: {
    session: {
      type: String,
      required: true
    }
  },
  computed: {
    inscriptionPaid() {
      if (this.selectedUser) if (this.selectedUser.inscription_paid) return this.selectedUser.inscription_paid.includes(this.session)
      return false
    },
    ...mapGetters(['selectedUser'])
  },
  methods: {
    togglePayment(user) {
      if (user.inscription_paid) {
        if (user.inscription_paid.includes(this.session)) {
          this.unpay(user)
          return
        }
      }
      this.pay(user)
    },
    pay(user) {
      this.loading = true
      this.$store.dispatch(actions.USER_PAY, {user, session: this.session}).then(() => {
        this.loading = false
      })
        .catch(() => {
          this.loading = false
        })
    },
    unpay(user) {
      this.loading = true
      this.$store.dispatch(actions.USER_UNPAY, {user, session: this.session}).then(() => {
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
