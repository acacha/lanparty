<template>
    <form>
        <v-text-field
                label="Email a on voleu enviar la invitació"
                v-model="email"
                required
        ></v-text-field>
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
     loading: false
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
  }
}
</script>
