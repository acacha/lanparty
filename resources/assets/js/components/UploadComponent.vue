<template>
    <div>
        <img ref="avatar" :src="filePath" alt="Avatar" width="50"
             @click="selectUploadFile">
        <v-text-field
            prepend-icon="attach_file" single-line
            v-model="filename" :label="label" :required="required"
            @click.native="selectUploadFile"
            :disabled="disabled" ref="fileTextField">
        </v-text-field>
        <!--<v-btn @click="uploadAvatar" color="info">Upload Avatar</v-btn>-->
        <input type="file" :accept="accept" :multiple="false" :disabled="disabled"
               ref="fileInput" @change="onFileChange">
    </div>
</template>

<style scoped>
    input[type=file] {
        position: absolute;
        left: -99999px;
    }
</style>

<script>
  import axios from 'axios'
  export default{
    name: 'Upload',
    props: {
      value: {
        type: [Array, String]
      },
      accept: {
        type: String,
        default: '*'
      },
      label: {
        type: String,
        default: 'Please choose a file...'
      },
      required: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      multiple: {
        type: Boolean, // not yet possible because of data
        default: false
      }
    },
    data () {
      return {
        filename: this.value,
        file: null,
        filePath: 'img/groupPlaceholder.jpg'
      }
    },
    watch: {
      value (v) {
        this.filename = v
      }
    },
    methods: {
//      uploadAvatar () {
//        console.log('uploadAvatar')
//
//        const formData = new FormData()
//        formData.append('avatar', this.$refs.fileInput.files[0])
//
//        axios.post('/group/1/avatar', formData).then(response => {
//          console.log(response)
//        }).catch(error => {
//          console.log(error)
//        })
//      },
      getFormData (files) {
        const data = new FormData();
        [...files].forEach(file => {
          data.append('data', file, file.name) // currently only one file at a time
        })
        return data
      },
      selectUploadFile () {
        if (!this.disabled) {
          this.$refs.fileInput.click()
        }
      },
      preview (file) {
        let reader = new FileReader()
        reader.onload = f => {
//          this.$refs.avatar.setAttribute('src', f.target.result)
          this.filePath = f.target.result
        }
        reader.readAsDataURL(file)
      },
      onFileChange (event) {
        var target = event.target || event.srcElement
        this.file = target.files[0]
        this.filename = target.files[0].name
        this.preview(this.file)

        // const files = event.target.files || event.dataTransfer.files
        // const form = this.getFormData(files)
        // if (files) {
        //  if (files.length > 0) {
        //    this.filename = [...files].map(file => file.name).join(', ')
        //  } else {
        //    this.filename = null
        //  }
        // } else {
        //  this.filename = event.target.value.split('\\').pop()
        // }
        // this.$emit('input', this.filename)
        // this.$emit('formData', form)
      }
    }
  }
</script>
