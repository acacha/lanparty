<template>
  <span>
    <v-btn v-if="!event.image" fab dark color="primary">
      <v-icon @click="selectFiles" dark>add</v-icon>
    </v-btn>
    <v-btn v-else fab flat color="primary">
      <img width="60" @click="selectFiles" ref="img_image" :src="event.image">
    </v-btn>
    <input type="file" name="image" id="image-file-input" ref="image" accept="image/*" @change="upload">
  </span>
</template>

<script>
export default {
  name: 'EventImageUpload',
  data () {
    return {
      dataEvents: this.events
    }
  },
  props: {
    event: {
      type: Object,
      required: true
    }
  },
  methods: {
    saveImage (formData) {
      this.uploading = true
      let config = {
        onUploadProgress: progressEvent => {
          this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        }
      }
      window.axios.post('/api/v1/event/image', formData, config)
        .then(() => {
          this.uploading = false
          this.$snackbar.showMessage("La foto s'ha pujat correctament!")
          this.$emit('change')
        })
        .catch(error => {
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
      formData.append('image', this.$refs.image.files[0])
      formData.append('event_id', this.event.id)
      // save it
      this.saveImage(formData)
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
