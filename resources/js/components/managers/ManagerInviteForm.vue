<template>
    <form>
        <v-combobox
                v-model="email"
                :items="emails"
                label="Email a on voleu enviar la invitació"
        ></v-combobox>
        <v-btn
                color="primary"
                @click="send"
                :loading="loading"
        >Enviar</v-btn>
    </form>
</template>

<script>
export default {
 name: 'ManagerInviteForm',
 data () {
   return {
     email: '',
     loading: false,
     emails: []
   }
  },
  props: {
    users: {
      type: Array,
      required: true
    }
  },
  methods: {
   send () {
     this.loading = true
     window.axios.post('/api/v1/manage/managers/send_invitation', { email: this.email }).then(() => {
       this.email = ''
       this.loading = false
       this.$snackbar.showMessage('Invitació enviada correctament')
     }).catch(() => {
       this.loading = false
     })
   }
  },
  created () {
    this.emails = this.users.map((user) => {
      return user.email
    })
  }
}
</script>
