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
                            :error-messages="internalEmailErrors"
                            @input="$v.internalEmail.$touch()"
                            @blur="$v.internalEmail.$touch()"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password"
                            label="Paraula de pas"
                            v-model="password"
                            :error-messages="passwordErrors"
                            @input="$v.password.$touch()"
                            @blur="$v.password.$touch()"
                            hint="Com a mínim 8 caràcters"
                            min="8"
                            type="password"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password_confirmation"
                            label="Confirmació paraula de pas"
                            v-model="passwordConfirmation"
                            :error-messages="passwordConfirmationErrors"
                            @input="$v.passwordConfirmation.$touch()"
                            @blur="$v.passwordConfirmation.$touch()"
                            hint="Com a mínim 8 caràcters"
                            min="8"
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
                        :disabled="loading || $v.$invalid"
                        :color="loadingDone ? 'success' : 'primary'"
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
import { validationMixin } from 'vuelidate'
import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'

export default {
  name: 'ResetPasswordDialog',
  mixins: [validationMixin],
  validations: {
    internalEmail: { required, email },
    password: { required, minLength: minLength(8) },
    passwordConfirmation: { sameAsPassword: sameAs('password') }
  },
  data() {
    return {
      internalAction: this.action,
      errorMessage: '',
      errors: [],
      loading: false,
      loadingDone: false,
      valid: false,
      internalEmail: this.email,
      password: '',
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
    passwordErrors () {
      const passwordErrors = []
      if (!this.$v.password.$dirty) return passwordErrors
      !this.$v.password.minLength && passwordErrors.push('El password ha de tenir com a mínim 8 caràcters.')
      !this.$v.password.required && passwordErrors.push('La paraula de pas és obligatòria.')
      return passwordErrors
    },
    passwordConfirmationErrors () {
      const passwordConfirmationErrors = []
      if (!this.$v.passwordConfirmation.$dirty) return passwordConfirmationErrors
      !this.$v.passwordConfirmation.sameAsPassword && passwordConfirmationErrors.push('Les paraules de pas han de coincidir')
      return passwordConfirmationErrors
    },
    internalEmailErrors () {
      const internalEmailErrors = []
      if (!this.$v.internalEmail.$dirty) return internalEmailErrors
      !this.$v.internalEmail.email && internalEmailErrors.push('El correu electrònic ha de ser vàlid')
      !this.$v.internalEmail.required && internalEmailErrors.push('El correu electrònic és obligatori.')
      this.errors['email'] && internalEmailErrors.push(this.errors['email'])
      return internalEmailErrors
    }
  },
  methods: {
    reset () {
      const user = {
        'email': this.internalEmail,
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
