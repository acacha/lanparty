<template>
    <span>
        Total a Pagar: {{ totalToPay }}
        <v-switch
                label="Pagat"
                :input-value="inscriptionPaid"
                @change="togglePayment(selectedUser)"
                :loading="loading"
                :disabled="loading"
        ></v-switch>
    </span>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../../store/action-types'
import helpers from '../../utils/helpers'

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
    ...mapGetters(['selectedUser']),
    totalToPay() {
      return helpers.priceInEuros(this.selectedUser.total_to_pay)
    }
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
