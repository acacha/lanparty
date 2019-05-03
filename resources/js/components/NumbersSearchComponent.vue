<template>
    <v-card flat>
        <v-card-text>
            <v-container fluid>
                <v-layout row wrap>
                    <v-flex xs12>
                        Números:
                        <v-chip label color="orange darken-3" text-color="white">
                            <v-icon left>group</v-icon>Total: {{ this.internalNumbers.length }}
                        </v-chip>
                        <v-chip label color="success darken-3" text-color="white">
                            <v-icon left>group</v-icon>Assignats: {{ this.assignedNumbers.length }}
                        </v-chip>
                        <v-chip label color="accent darken-3" text-color="white">
                            Números disponibles: {{ this.availableNumbers.length }}
                        </v-chip>
                        <span style="display: inline-flex;">
                            <add-numbers-button :session="session"></add-numbers-button>
                            <delete-numbers-button :session="session"></delete-numbers-button>
                        </span>
                    </v-flex>
                    <v-flex xs12>
                        <v-checkbox
                                label="Només números assignats"
                                v-model="assigned"
                        ></v-checkbox>
                    </v-flex>
                    <v-flex xs12>
                        <v-autocomplete
                                label="Seleccioneu un número de sorteig"
                                v-bind:items="filteredNumbers"
                                v-model="selected_number_id"
                                item-text="full_search"
                                :menu-props="{maxHeight:'300'}"
                                clearable
                                @input="input"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        @input="data.parent.selectItem(data.item)"
                                        :selected="data.selected"
                                        class="chip--select"
                                        :key="data.item.id"
                                >
                                    <v-avatar>
                                        <img :src="gravatarURL(data.item)">
                                    </v-avatar>
                                    {{ data.item.value }} | {{ data.item.session }} | {{ userInfoFormNumber(data.item) }}
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
                                            {{ userInfoFormNumber(data.item) }} | Sessió: {{ data.item.session }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
  import gravatar from 'gravatar'
  import randomColor from './mixins/randomColor'
  import * as mutations from '../store/mutation-types'
  import * as actions from '../store/action-types'
  import AddNumbersButton from '../numbers/AddNumbersButton'
  import DeleteNumbersButton from '../numbers/DeleteNumbersButton'

  // Numbers filters
  const filters = {
    assigned: function (numbers) {
      return numbers.filter(function (number) {
        return number.user_id
      })
    }
  }

  export default {
    name: 'NumbersSearch',
    mixins: [ randomColor ],
    components: {
      'add-numbers-button': AddNumbersButton,
      'delete-numbers-button': DeleteNumbersButton,
    },
    data () {
      return {
        selected_number_id: null,
        assigned: true
      }
    },
    props: {
      numbers: {
        type: Array
      },
      session: {
        type: String,
        required: true
      }
    },
    computed: {
      internalNumbers () {
        return this.$store.getters.numbers.filter((number) => {
          return number.session === this.session
        })
      },
      availableNumbers () {
        let availableNumbers = this.$store.getters.numbers.filter((number) => {
          return !number.user_id && number.session === this.session
        })
        if (availableNumbers) return availableNumbers
        return []
      },
      filteredNumbers: function () {
        if (this.assigned) {
          return filters['assigned'](this.internalNumbers)
        }
        return this.internalNumbers
      },
      assignedNumbers: function () {
        return filters['assigned'](this.internalNumbers)
      }
    },
    methods: {
      input (number) {
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
          return 'Usuari: ' + number.user.name + ' | Nom: ' + (number.user.givenName || '') + ' ' + ( number.user.sn1 || '') + ' ' + ( number.user.sn2 || '' ) + ' (' + number.user.id + ')'
        }
        return 'Cap usuari té assignat aquest número'
      }
    },
    mounted () {
      if (this.numbers) this.$store.commit(mutations.SET_NUMBERS, this.numbers)
      else this.$store.dispatch(actions.FETCH_NUMBERS)
    }
  }
</script>
