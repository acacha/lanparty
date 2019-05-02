<template>
    <v-dialog v-model="show" persistent max-width="500px">
        <v-card class="pa-3">
            <v-card-title>
                <span class="headline">Restaureu la paraula de pas</span>
            </v-card-title>
            <v-card-text>
                <v-alert v-if="errorMessage" color="error" icon="warning" value="true" dismissible>
                    <h3>{{errorMessage}}</h3>
                    <p v-for="(error, errorKey) in errors">{{errorKey}} : {{ error[0] }}</p>
                </v-alert>
                <v-form v-model="valid">
                    <v-text-field
                            label="Correu electrònic"
                            v-model="internalEmail"
                            :rules="emailRules"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password"
                            label="Paraula de pas"
                            v-model="password"
                            :rules="passwordRules"
                            hint="Com a mínim 6 caràcters"
                            min="6"
                            type="password"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password_confirmation"
                            label="Confirmació paraula de pas"
                            v-model="passwordConfirmation"
                            :rules="passwordRules"
                            hint="Com a mínim 6 caràcters"
                            min="6"
                            type="password"
                            required
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary darken-1" flat @click.native="show = false">Tancar</v-btn>
                <v-btn
                        :loading="loading"
                        :color="loadingDone ? 'green' : 'primary'"
                        @click.native="reset"
                >
                    <v-icon v-if="loadingDone">done</v-icon>
                    &nbsp;
                    <template v-if="!loadingDone">Restaurar</template>
                    <template v-else>Fet</template>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import * as actions from '../store/action-types'
import sleep from '../utils/sleep'

export default {
  name: 'ResetPasswordDialog',
  data() {
    return {
      internalAction: this.action,
      errorMessage: '',
      errors: [],
      loading: false,
      loadingDone: false,
      emailRules: [
        (v) => !!v || 'El email és obligatori',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'S\'ha d\'indicar un email vàlid'
      ],
      valid: false,
      internalEmail: this.email,
      password: '',
      passwordRules: [
        (v) => !!v || 'La paraula de pas és obligatòria',
        (v) => v.length >= 6 || 'La paraula de pas ha de tenir com a mínim 6 caràcters'
      ],
      passwordConfirmation: '',
    }
  },
  props: {
    email: {
      type: String,
      default: null
    },
    resetPasswordToken: {
      type: String,
      default: null
    },
    action: {
      type: String,
      default: null
    }
  },
  computed: {
    show: {
      get() {
        if (this.internalAction && this.internalAction === 'reset_password') return true
        return false
      },
      set(value) {
        if (value) this.internalAction = 'reset_password'
        else this.internalAction = null
      }
    },
  },
  methods: {
    reset () {
      const user = {
        'email': this.internalResetPasswordEmail,
        'password': this.password,
        'password_confirmation': this.passwordConfirmation,
        'token': this.resetPasswordToken
      }
      this.loading = true
      this.$store.dispatch(actions.RESET_PASSWORD, user).then(() => {
        this.loading = false
        this.loadingDone = true
        sleep(4000).then(() => {
          this.showResetPassword = false
          window.location = '/home'
        })
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
