<template>
    <v-layout row wrap align-center>
        <v-flex xs1 class="text-xs-center">
            <img ref="avatar" :src="filePath" alt="Avatar" style="max-width: 100%;max-height: 100%;"
                 @click="selectUploadFile" @dragover="dragover" @dragleave="dragleave" @drop="drop"
                 v-bind:class="{ isDragging: dragging }">
        </v-flex>
        <v-flex xs11>
            <v-text-field
                    prepend-icon="attach_file" single-line
                    v-model="filename" :label="label" :required="required"
                    @click.native="selectUploadFile"
                    :disabled="disabled" ref="fileTextField"
                    >
            </v-text-field>
            <input type="file" :accept="accept" :multiple="false" :disabled="disabled"
                   ref="fileInput" @change="onFileChange">
        </v-flex>
    </v-layout>
</template>

<style scoped>
    input[type=file] {
        position: absolute;
        left: -99999px;
    }
    .isDragging {
        opacity: 0.5;
        filter: alpha(opacity=50); /* For IE8 and earlier */
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
        filePath: 'img/groupPlaceholder.jpg',
        dragging: false
      }
    },
    watch: {
      value (v) {
        this.filename = v
      }
    },
    methods: {
      dragover (e) {
        e.preventDefault()
        e.stopPropagation()
        this.dragging = true
      },
      dragleave (e) {
        e.preventDefault()
        e.stopPropagation()
        this.dragging = false
      },
      drop (e) {
        e.preventDefault()
        e.stopPropagation()
        this.dragging = false
        let files
        if (e.dataTransfer) {
          files = e.dataTransfer.files
        } else if (e.target) {
          files = e.target.files
        }
        if (files[0].type.startsWith('image')) {
          this.file = files[0]
          this.filename = files[0].name
          this.preview(files[0])
        }
      },
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
          this.filePath = f.target.result
        }
        reader.readAsDataURL(file)
      },
      onFileChange (event) {
        var target = event.target || event.srcElement
        this.file = target.files[0]
        this.filename = target.files[0].name
        this.preview(this.file)
      }
    }
  }
</script>
