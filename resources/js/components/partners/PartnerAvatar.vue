<template>
  <span>
        <v-btn fab dark color="primary" v-if="!partner.avatar">
          <v-icon @click="selectFiles" dark>add</v-icon>
        </v-btn>
        <v-btn fab flat color="primary" v-else>
          <img width="60" @click="selectFiles" ref="img_image" :src="partner.avatar">
        </v-btn>
        <input type="file" name="image" id="image-file-input" ref="image" accept="image/*" @change="upload">
  </span>
</template>

<script>
export default {
  name: 'PartnerAvatar',
  data () {
    return {
      dataPartner: this.partner
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    }
  },
  methods: {
    saveAvatar (formData) {
      this.uploading = true
      let config = {
        onUploadProgress: progressEvent => {
          this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        }
      }
      window.axios.post('/api/v1/partner/avatar', formData, config)
        .then(() => {
          this.uploading = false
          this.$snackbar.showMessage("L'avatar s'ha pujat correctament!")
          this.$emit('change')
        })
        .catch(error => {
          console.log(formData)
          console.log(error)
          this.$snackbar.showError(error)
          this.uploading = false
        })
    },
    selectFiles () {
      this.$refs.image.click()
    },
    upload () {
      const formData = new FormData()
      formData.append('avatar', this.$refs.image.files[0])
      formData.append('partner_id', this.partner.id)
      // save it
      this.saveAvatar(formData)
    }
  }
}
</script>

<style scoped>
  input[type=file] {
    position: absolute;
    left: -99999px;
  }
</style>
