<template>
    <span>
        <v-tooltip bottom>
            <v-btn icon color="primary" flat slot="activator" @click="dialog=true">
                <v-icon>remove</v-icon>
            </v-btn>
            <span>Eliminar tiquets</span>
        </v-tooltip>
        <v-dialog
                v-model="dialog"
                width="500"
        >
            <v-card>
                <v-card-title
                        class="title primary darken-3 white--text"
                >
                  Eliminar tiquets de la sessió: {{ session}}
                </v-card-title>

                <v-card-text>
                    <v-text-field
                            label="Quantitat"
                            v-model="quantity"
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
                          @click="remove"
                          :loading="removing"
                          :disabled="removing || $v.$invalid"
                  >
                    Eliminar
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
    name: 'DeleteTicketsButton',
    mixins: [validationMixin],
    validations: {
      quantity: { required, numeric }
    },
    data () {
      return {
        dialog: false,
        removing: false,
        quantity: null
      }
    },
    props: {
      session: {
        type: String,
        required: true
      }
    },
    methods: {
      remove() {
        this.removing = true
        window.axios.post('/api/v1/tickets/remove',{
          session: this.session,
          quantity: this.quantity
        }).then(() => {
          this.removing = false
          this.$snackbar.showMessage('Tiquets eliminats correctament')
          this.dialog = false
          this.$store.dispatch(actions.FETCH_TICKETS)
        }).catch((error) => {
          if (error.response.status === 422) {
            if (error.response.data.message === 'NO és possible realitzar accions en sessions arxivades.') {
              this.$snackbar.showError(error.response.data.message)
              this.dialog = false
            } else {
              this.$snackbar.showMessage('Tiquets restants eliminats correctament')
              this.dialog = false
              this.$store.dispatch(actions.FETCH_TICKETS)
            }
          }
          this.removing = false
        })
      }
    }
  }
</script>
