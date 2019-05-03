<template>
    <span>
        <v-tooltip bottom>
            <v-btn icon color="primary" flat slot="activator" @click="dialog=true">
                <v-icon>add</v-icon>
            </v-btn>
            <span>Afegir més tiquets</span>
        </v-tooltip>
        <v-dialog
                v-model="dialog"
                width="500"
        >
            <v-card>
                <v-card-title
                        class="title primary darken-3 white--text"
                >
                  Afegir tiquets a la sessió: {{ session}}
                </v-card-title>

                <v-card-text>
                    <v-text-field
                            label="Quantitat"
                            v-model="quantity"
                            :error-messages="quantityErrors"
                            @input="$v.quantity.$touch()"
                            @blur="$v.quantity.$touch()"
                    ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                            color="primary"
                            flat
                            @click="dialog = false"
                    >
                    Tancar
                  </v-btn>
                  <v-btn
                          color="primary"
                          @click="add"
                          :loading="adding"
                          :disabled="adding || $v.$invalid"
                  >
                    Afegir
                  </v-btn>
                </v-card-actions>
              </v-card>
        </v-dialog>
    </span>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required, numeric } from 'vuelidate/lib/validators'
import * as actions from '../../store/action-types'

export default {
  name: 'AddTicketsButton',
  mixins: [validationMixin],
  validations: {
    quantity: { required, numeric }
  },
  data () {
    return {
      dialog: false,
      adding: false,
      quantity: null
    }
  },
  props: {
    session: {
      type: String,
      required: true
    }
  },
  computed: {
    quantityErrors() {
      const quantityErrors = []
      if (!this.$v.quantity.$dirty) return quantityErrors
      !this.$v.quantity.numeric && quantityErrors.push("Heu d'utilitzar un número enter positiu com a quantitat.")
      !this.$v.quantity.required && quantityErrors.push('És obligatori indicar una quantitat.')
      return quantityErrors
    }
  },
  methods: {
    add() {
      this.adding = true
      window.axios.post('/api/v1/tickets',{
        session: this.session,
        quantity: this.quantity
      }).then(() => {
        this.adding = false
        this.$snackbar.showMessage('Tiquets afegits correctament')
        this.dialog = false
        this.$store.dispatch(actions.FETCH_TICKETS)
      }).catch(() => {
        this.adding = false
      })
    }
  }
}
</script>
