<template>
    <v-card tile>
        <v-toolbar card dark color="primary">
            <v-btn icon @click.native="close" dark>
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Inscripció a una competició de grup</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn dark flat @click.native="register" :loading="registering">Inscriure grup</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-alert type="error" :value="true" class="mb-3" dismissible v-model="alert">
                Les inscripcions a una competició les ha de realitzar només el líder del grup inscrivint a tots els components del grup.
            </v-alert>

            <v-chip>
                <v-avatar>
                    <img :src="gravatarURL(user.email)">
                </v-avatar>
                {{ user.name }}
            </v-chip>

            <span class="subheading">sóc el líder del grup amb nom:</span>

            <v-form v-model="valid" ref="registrationGroupForm">
                <v-text-field
                        label="Nom del grup"
                        v-model="name"
                        :rules="nameRules"
                        :counter="50"
                        required
                ></v-text-field>

                <v-layout row wrap align-center>
                    <v-flex xs1 class="text-xs-center">
                        <img ref="avatar" :src="filePath" alt="Avatar" style="max-width: 100%;max-height: 100%;"
                             @click="selectUploadFile" @dragover="dragover" @dragleave="dragleave" @drop="drop"
                             v-bind:class="{ isDragging: dragging }">
                    </v-flex>
                    <v-flex xs11>
                        <v-text-field
                            prepend-icon="attach_file"
                            single-line
                            v-model="avatarFilename"
                            label="Escolliu un avatar pel grup o arrosegueu una imatge"
                            @click.native="selectUploadFile"
                            ref="fileTextField"
                            :rules="avatarRules"
                            required
                        >
                        </v-text-field>
                        <input type="file" accept="image/*" ref="fileInput" @change="onFileChange">
                    </v-flex>
                </v-layout>

                <template v-for="n in numberOfParticipants()">
                    <v-users-search :users="users" @input="userSelected(n+1, $event)" :label="'Participant ' + n" :return-object="true"></v-users-search>
                </template>

                <v-btn dark color="primary" @click.native="register" :loading="registering">Inscriure grup</v-btn>

            </v-form>
        </v-card-text>
    </v-card>
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
  import VUsersSearch from './VUsersSearchComponent.vue'
  import { mapGetters } from 'vuex'
  import * as actions from '../store/action-types'
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import sleep from '../utils/sleep'

  export default {
    name: 'Group',
    components: { VUsersSearch },
    mixins: [interactsWithGravatar],
    data () {
      return {
        alert: true,
        valid: false,
        registering: false,
        name: '',
        ids: {},
        nameRules: [
          v => !!v || 'El nom és obligatori',
          v => v.length <= 50 || 'Name must be less than 50 characters'
        ],
        avatarRules: [
          v => !!v || 'El avatar és obligatori'
        ],
        selectedUsers: [],
        avatarFilename: null,
        avatar: null,
        filePath: 'img/groupPlaceholder.jpg',
        dragging: false
      }
    },
    computed: {
      ...mapGetters({
        user: 'user'
      })
    },
    props: {
      dialog: {
        type: Boolean,
        default: false
      },
      event: {
        type: Object,
        required: true
      },
      users: {
        type: Array
      }
    },
    methods: {
      numberOfParticipants () {
        if (this.event.participants_number) return parseInt(this.event.participants_number) - 1
      },
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
          this.avatar = files[0]
          this.avatarFilename = files[0].name
          this.preview(files[0])
        }
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
        this.avatar = target.files[0]
        this.avatarFilename = target.files[0].name
        this.preview(this.avatar)
      },
      userSelected (n, user) {
        if (user) {
          if (this.isUserAlreadySelected(user)) {
            this.$snackbar.showError({message: "L'usuari ja ha estat seleccionat prèviament!"})
            return
          }
          this.ids[n] = user.id
          this.selectedUsers.push(user)
        } else {
          if (this.ids[n]) {
            const oldId = this.ids[n]
            let oldUser = this.selectedUsers.find(user => {
              return user.id === oldId
            })
            this.selectedUsers.splice(this.selectedUsers.indexOf(oldUser), 1)
          }
          delete this.ids[n]
        }
      },
      isUserAlreadySelected (user) {
        return new Set(this.selectedUsers).has(user)
      },
      register () {
        this.alert = false
        if (this.$refs.registrationGroupForm.validate()) {
          let ids = Object.values(this.ids)
          let index = ids.indexOf(this.user.id)

          let userIds = this.selectedUsers.map(user => user['id'])

          this.registering = true
          const group = {
            name: this.name,
            avatar: this.avatar,
            user_ids: JSON.stringify(userIds)
          }
          this.$store.dispatch(actions.REGISTER_GROUP_TO_EVENT, {event: this.event, group: group}).then((response) => {
            this.$snackbar.showMessage('Inscripció del grup realitzada correctament!')
            this.registering = false
            sleep(3000).then(() => { this.close() })
          }).catch(() => {
            this.registering = false
          })
        }
      },
      close () {
        this.$emit('close')
      }
    },
    mounted () {
      this.ids[1] = this.user.id
    }
  }
</script>
