<template>
    <div>
        <v-snackbar
                timeout="6000"
                :color="snackbarColor"
                v-model="snackbar"
                :vertical="true"
        >
            {{ snackbarText }}
            <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-dialog fullscreen v-model="showInscribeToGroupEvent" transition="dialog-bottom-transition"
                  :overlay="false"
                  scrollable>
           <group
                    :event="currentEvent"
                    @close="showInscribeToGroupEvent=false;"
                    :dialog="true"
            ></group>
        </v-dialog>
        <v-card>
            <v-card-title class="blue darken-3 white--text"><h2>Events</h2></v-card-title>
            <v-card-text class="px-0 mb-2">
                <v-data-table
                        :headers="headers"
                        :items="internalEvents"
                        hide-actions
                        item-key="name"
                        expand
                >
                    <template slot="items" slot-scope="props">
                        <tr @click="expand($event, props)">
                            <td class="text-xs-left">
                                <v-avatar>
                                    <img :src="props.item.image">
                                </v-avatar>
                                {{ props.item.name }}
                            </td>
                            <td class="text-xs-left">
                                <template v-if="props.item.inscription_type_id == 1">
                                    Grup
                                </template>
                                <template v-else>
                                    Individual
                                </template>
                            </td>
                            <td class="text-xs-left">{{ props.item.tickets }}</td>
                            <td class="text-xs-left">{{ props.item.assigned_tickets }}</td>
                            <td class="text-xs-left">{{ props.item.available_tickets }}</td>
                            <td class="text-xs-left"><a @click.stop="return;" :href="props.item.regulation" target="_blank">Clica'm</a></td>
                            <td class="text-xs-right">
                                <v-progress-circular v-if="props.item.loading" indeterminate color="primary"></v-progress-circular>
                                <v-switch v-else
                                          :input-value="props.item.inscribed"
                                          @change="toogleInscription(props.item)"
                                          :disabled="props.item.available_tickets < 1"></v-switch>
                            </td>
                        </tr>
                    </template>
                    <template slot="expand" slot-scope="props">
                        <v-card>
                            <v-card-text>
                                <template v-if="props.item.inscription_type_id == 1">
                                    <v-list two-line>
                                        <template v-for="(group, index) in props.item.groups">
                                            <v-list-tile avatar :key="group.title" @click="">
                                                <v-list-tile-avatar>
                                                    <template v-if="group.avatar">
                                                        <img :src="group.avatar">
                                                    </template>
                                                    <template v-else>
                                                        <img src="/img/groupPlaceholder.jpg">
                                                    </template>
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>{{group.name}}</v-list-tile-title>
                                                    <v-list-tile-sub-title>
                                                        Leader:
                                                        <template v-if="group.leader">{{group.leader.sn1}} {{group.leader.sn2}},{{group.leader.givenName}} ({{group.leader.name}})</template>
                                                        <template v-else>No leader assigned</template>
                                                        | Team members:
                                                        <template v-if="group.users">{{group.leader.sn1}} {{group.leader.sn2}},{{group.leader.givenName}} ({{group.leader.name}})</template>
                                                        <template v-else>No members assigned</template>
                                                    </v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                        </template>
                                    </v-list>
                                </template>
                                <template v-else>
                                    <v-list two-line>
                                        <template v-for="(user, index) in props.item.users">
                                            <v-list-tile avatar :key="user.title" @click="">
                                                <v-list-tile-avatar>
                                                    <img :src="gravatarURL(user.email)">
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>{{user.sn1}} {{user.sn2}} , {{user.givenName}} ({{user.name}})</v-list-tile-title>
                                                    <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                        </template>
                                    </v-list>
                                </template>
                            </v-card-text>
                        </v-card>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<style>

</style>

<script>
  import InteractsWithGravatar from './mixins/interactsWithGravatar'
  import Group from './GroupComponent.vue'
  import * as mutations from '../store/mutation-types'
  import * as actions from '../store/action-types'
  import { mapGetters } from 'vuex'

  const GROUP = '1'

  export default {
    name: 'Events',
    components: { Group },
    mixins: [InteractsWithGravatar],
    data () {
      return {
        snackbarColor: 'error',
        snackbarText: 'An error occurred',
        snackbar: false,
        showInscribeToGroupEvent: false,
        currentEvent: null,
        inscriptions: [],
        avoidExpand: false,
        headers: [
          { text: 'Nom', align: 'left', value: 'name' },
          { text: 'Tipus', value: 'inscription_type_id' },
          { text: 'Places', value: 'tickets' },
          { text: 'Inscrits', value: 'assigned_tickets' },
          { text: 'Disponibles', value: 'available_tickets' },
          { text: 'Reglament', value: 'rules_link' },
          { text: 'Inscrit?', value: 'inscribed' }
        ]
      }
    },
    props: {
      events: {
        type: Array,
        required: false
      }
    },
    computed: {
      ...mapGetters({
        internalEvents: 'events'
      })
    },
    methods: {
      showError (message) {
        this.showSnackBar(message, 'error')
      },
      showSnackBar (message, color) {
        this.snackbar = true
        this.snackbarText = message
        this.snackbarColor = color || this.snackbarColor
      },
      expand (event, props) {
        if (this.avoidExpand) {
          this.avoidExpand = false
          return
        }
        props.expanded = !props.expanded
      },
      toogleInscription (event) {
        this.avoidExpand = true
        if (!event.inscribed) this.registerToEvent(event)
        else this.unregisterToEvent(event)
      },
      registerToEvent (event) {
        if (event.inscription_type_id === GROUP) {
          this.showInscribeToGroupEvent = true
          this.currentEvent = event
        } else {
          this.$store.dispatch(actions.REGISTER_CURRENT_USER_TO_EVENT, event).catch(error => {
            console.dir(error)
            this.showError(error.message)
          })
        }
      },
      unregisterToEvent (event) {
        if (event.inscription_type_id === GROUP) {
          console.log('unregister to group event')
        } else {
          this.$store.dispatch(actions.UNREGISTER_CURRENT_USER_TO_EVENT, event).catch(error => {
            console.dir(error)
            this.showError(error.message)
          })
        }
      }
    },
    created () {
      if (this.events) this.$store.commit(mutations.SET_EVENTS, this.events)
      else this.$store.dispatch(actions.FETCH_EVENTS)
    }
  }
</script>
