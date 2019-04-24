<template>
    <v-dialog v-model="show" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">Recordeu-me la paraula de pas</span>
            </v-card-title>
            <v-card-text>
                <v-alert v-if="errorMessage" color="error" icon="warning" value="true" dismissible>
                    <h3>{{errorMessage}}</h3>
                    <p v-for="(error, errorKey) in errors">{{errorKey}} : {{ error[0] }}</p>
                </v-alert>
                <v-form v-model="valid">
                    <v-text-field
                            label="Correu electrònic"
                            v-model="email"
                            :rules="emailRules"
                            :error="errors['email']"
                            :error-messages="errors['email']"
                            required
                    ></v-text-field>
                </v-form>
                <a href="/login" color="primary darken-2">
                    Entrar
                </a> &nbsp; |
                <a href="/register" color="primary darken-2">
                    Registra't
                </a>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary darken-1" flat @click.native="show = false">Tancar</v-btn>
                <v-btn
                        :loading="loading"
                        flat
                        :color="loadingDone ? 'green' : 'blue'"
                        @click.native="rememberPassword"
                >
                    <v-icon v-if="!loadingDone">mail_outline</v-icon>
                    <v-icon v-else>done</v-icon>
                    &nbsp;
                    <template v-if="!loadingDone">Enviar</template>
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
  name: 'RememberPasswordDialog',
  data () {
    return {
      errorMessage: '',
      errors: [],
      loading: false,
      loadingDone: false,
      email: '',
      emailRules: [
        (v) => !!v || 'El email és obligatori',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'S\'ha d\'indicar un email vàlid'
      ],
      valid: false
    }
  },
  computed: {
    show: {
      get() {
        if (this.internalAction && this.internalAction === 'request_new_password') return true
        return false
      },
      set(value) {
        if (value) this.internalAction = 'request_new_password'
        else this.internalAction = null
      }
    }
  },
  methods: {
    rememberPassword () {
      this.rememberPasswordLoading = true
      this.$store.dispatch(actions.REMEMBER_PASSWORD, this.email).then(() => {
        this.loading = false
        this.loadingDone = true
        sleep(4000).then(() => { this.show = false })
      }).catch(error => {
        this.errorMessage = error.response.data.message
        this.errors = error.response.data.errors
      }).then(() => {
        this.loading = false
      })
    }
  }
}
</script>
