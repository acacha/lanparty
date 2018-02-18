<template>
    <v-card>
        <v-card-title>
            Inscripció
        </v-card-title>
        <v-card-text>
            <v-alert type="error" :value="true" class="mb-3">
                Les inscripcions a una competició les ha de realitzar només el lider del grup!
            </v-alert>

            <span class="subheading">Sóc el lider del grup i li poso el nom:</span>

            <v-form v-model="valid">
                <v-text-field
                        label="Nom del grup"
                        v-model="name"
                        :rules="nameRules"
                        :counter="30"
                        required
                ></v-text-field>

                <upload label="Escolliu un avatar pel grup"></upload>

                <v-text-field
                        label="Líder"
                        v-model="lider"
                        readonly
                ></v-text-field>

                <template v-for="n in 4">
                    <users-search :label="'Membre del grup ' + n"></users-search>
                </template>

            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" flat @click.stop="close" v-if="dialog" >Close</v-btn>
            <v-btn color="primary" dark @click.stop="">Inscriure el grup</v-btn>
        </v-card-actions>
    </v-card>
</template>

<style>

</style>

<script>
  import UsersSearch from './UsersSearchComponent'
  import Upload from './UploadComponent'

  export default {
    name: 'Group',
    components: { UsersSearch, Upload },
    data () {
      return {
        name: '',
        nameRules: [
          v => !!v || 'El nom és obligatori',
          v => v.length <= 30 || 'Name must be less than 30 characters'
        ]
      }
    },
    props: {
      dialog: {
        type: Boolean,
        default: false
      },
      event: {
        type: Object,
        required: true
      }
    },
    methods: {
      close () {
        this.$emit('close')
      }
    }
  }
</script>
