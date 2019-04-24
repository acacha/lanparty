<template>
    <v-card class="elevation-0 text-xs-center" style="width: 400px;">
        <v-card-title style="align-items: center;justify-content: center;">
            <span class="title">Llista de correu electrònic</span>
            <em class="subheading">Apunta't i sigues el primer en rebre tota la informació de la LAN Party!</em>
        </v-card-title>
        <v-card-text>
            <v-form v-model="valid">
                <v-text-field
                        name="email"
                        label="E-mail"
                        v-model="email"
                        :rules="emailRules"
                        required
                        box
                        auto-grow
                ></v-text-field>
            </v-form>
            <template v-if="done">Comproveu el vostre email i seguiu les passes indicades!</template>
            <v-btn
                    :loading="loading"
                    class="darken-3 mt-2"
                    :class="{ green: done, orange: !done }"
                    dark
                    large
                    @click.native="addEmailToMailingList"
            >
                <v-icon v-if="!done">mail_outline</v-icon>
                <v-icon v-else>done</v-icon>
                &nbsp;
                <template v-if="!done">Apunta'm</template>
                <template v-else>Fet</template>
            </v-btn>
        </v-card-text>
    </v-card>
</template>

<script>
import * as actions from '../store/action-types'

export default {
  name: 'MailingListCard',
  data () {
    return {
      valid: false,
      loading: false,
      done: false,
      email: '',
      emailRules: [
        (v) => !!v || 'El email és obligatori',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'S\'ha d\'indicar un email vàlid'
      ],
    }
  },
  methods: {
    addEmailToMailingList () {
      this.loading = true
      this.$store.dispatch(actions.SUBSCRIBE_TO_NEWSLETTER, this.email).then(response => {
        this.done = true
      }).catch(error => {
        console.log(error)
        if (error.response.status !== 422) {
          this.done = true
        }
      }).then(() => {
        this.loading = false
      })
    }
  }
}
</script>
