<template>
  <v-edit-dialog
    :return-value.sync="partner.name"
    lazy
    @save="save(partner)"
    @cancel="cancel"
    @open="open(partner)"
    @close="close"
  >{{partner.name}}
    <template v-slot:input>
      <v-text-field
        v-model="partner.name"
        :rules="[max50chars]"
        label="Edit"
        single-line
        counter
      ></v-text-field>
    </template>
  </v-edit-dialog>
</template>

<script>
export default {
  name: 'PartnerEditNameInline',
  data () {
    return {
      max50chars: v => v.length <= 50 || 'Input too long!',
      loading: false
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true,
      default: '/api/v1/partners/inline/'
    }
  },
  methods: {
    save (partner) {
      this.loading = true
      const changeName = {
        name: partner.name
      }
      window.axios.put(this.uri + 'inline/' + partner.id, changeName).then((response) => {
        this.$snackbar.showMessage('Camp nom editat')
        this.$emit('change')
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    },
    cancel () {
      this.$snackbar.showError('Cancel·lat')
    },
    open (partner) {
      this.$snackbar.showSnackBar('Editant nom', 'info')
      // console.log(partner.id)
      // console.log(partner.name)
      // console.log(partner.category)
      // console.log(partner.session)
    },
    close () {
      console.log('dialog closed')
    }
  }
}
</script>

<style scoped>

</style>
