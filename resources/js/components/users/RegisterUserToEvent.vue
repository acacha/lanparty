<template>
    <span>
        <v-tooltip bottom>
            <v-btn icon slot="activator" @click="dialog = true">
                <v-icon color="teal">add_circle</v-icon>
            </v-btn>
            <span>Inscriure l'usuari a un esdeveniment</span>
        </v-tooltip>
        <v-dialog v-model="dialog" max-width="750px">
            <v-card>
                <v-card-title class="primary darken-3 white--text">
                    <span>Inscriure a un esdeveniment</span>
                </v-card-title>
                <v-card-text>
                    <v-select
                            :items="individualInscriptionEvents"
                            v-model="event"
                            label="Escolliu un esdeveniment"
                    >
                        <template slot="selection" slot-scope="data">
                            <v-chip class="chip--select">
                                {{ data.item.name }}
                            </v-chip>
                        </template>
                        <template slot="item" slot-scope="data">
                            <v-list-tile-avatar>
                                <img :src="data.item.image">
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                {{ data.item.name }} {{ data.item.session }}  ( Places: {{ data.item.available_tickets }})
                            </v-list-tile-content>
                        </template>
                    </v-select>

                    <!--                        <template slot="item" slot-scope="data">-->
                    <!--                            <template v-if="typeof data.item !== 'object'">-->
                    <!--                                <v-list-tile-content v-text="data.item"></v-list-tile-content>-->
                    <!--                            </template>-->
                    <!--                            <template v-else>-->
                    <!--                                <v-list-tile-avatar>-->
                    <!--                                    <img v-bind:src="gravatarURL(data.item.email)"/>-->
                    <!--                                </v-list-tile-avatar>-->
                    <!--                                <v-list-tile-content>-->
                    <!--                                    <v-list-tile-title>{{data.item.name}} | {{ data.item.givenName }} {{ data.item.sn1 }} {{ data.item.sn2 }}</v-list-tile-title>-->
                    <!--                                    <v-list-tile-sub-title>{{data.item.id}} | {{data.item.email}} | {{ data.item.formatted_created_at_date }}</v-list-tile-sub-title>-->
                    <!--                                </v-list-tile-content>-->
                    <!--                            </template>-->
                    <!--                        </template>-->

                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" flat @click.stop="dialog = false">Tancar</v-btn>
                    <v-btn v-if="!done" :loading="loading" :disabled="loading || event === null" color="primary" @click.stop="registerEvent">Inscriure</v-btn>
                    <v-btn v-else color="success" flat><v-icon>done</v-icon> Inscrit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </span>
</template>

<script>
import * as actions from '../../store/action-types'
import sleep from '../../utils/sleep'

export default {
  name: 'RegisterUserToEvent',
  data () {
    return {
      dialog: false,
      loading: false,
      event: null,
      done: false
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    },
  },
  computed: {
    individualInscriptionEvents () {
      if (this.events) {
        return this.events.filter((event) => {
          return event.inscription_type_id === '2'
        }).filter((event) => {
          return event.inscription_type_id === '2'
        })
      }
      return []
    }
  },
  methods: {
    registerEvent () {
      this.loading = true
      this.$store.dispatch(actions.REGISTER_USER_TO_EVENT, { user: this.selectedUser, event: this.event }).then((response) => {
        this.done = true
        this.loading = false
        sleep(1000).then(() => { this.dialog = false; this.done = false })
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
