<template>
    <v-card flat>
        <v-card-text>
            <v-container fluid>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-select
                                label="Seleccioneu un número de sorteig"
                                v-bind:items="numbers"
                                v-model="selected_number_id"
                                item-text="full_search"
                                max-height="auto"
                                autocomplete
                                @input="input"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="data.parent.selectItem(data.item)"
                                        :selected="data.selected"
                                        class="chip--select"
                                        :key="data.item.id"
                                >
                                    <v-avatar>
                                        <img :src="gravatarURL(data.item)">
                                    </v-avatar>
                                    {{ data.item.value }} | {{ userInfoFormNumber(data.item) }}
                                </v-chip>
                            </template>
                            <template slot="item" slot-scope="data">
                                <template>
                                    <v-list-tile-avatar>
                                        <img v-bind:src="gravatarURL(data.item)"/>
                                    </v-list-tile-avatar>
                                    <v-list-tile-avatar>
                                        <v-chip :color="randomColor()" text-color="white" >
                                            {{ data.item.value }}
                                            <v-icon right>star</v-icon>
                                        </v-chip>
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ userInfoFormNumber(data.item) }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </template>
                            </template>
                        </v-select>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
  import gravatar from 'gravatar'
  import randomColor from './mixins/randomColor'

  export default {
    name: 'NumbersSearch',
    mixins: [ randomColor ],
    data () {
      return {
        selected_number_id: null
      }
    },
    props: {
      numbers: {
        type: Array,
        required: true
      }
    },
    methods: {
      input (number) {
        console.log('INPUT EVENT FIRED')
        console.log(number)
        this.$emit('input', number)
      },
      gravatarURL (number) {
        if (number.user_id) {
          return gravatar.url(number.user.email)
        }
        return gravatar.url(null)
      },
      userInfoFormNumber (number) {
        if (number.user_id) {
          return 'Usuari: ' + number.user.name + ' | Nom: ' + number.user.givenName + ' ' + number.user.sn1 + ' ' + number.user.sn2 + ' (' + number.user.id + ')'
        }
        return 'Cap usuari té assignat aquest número'
      }
    }
  }
</script>