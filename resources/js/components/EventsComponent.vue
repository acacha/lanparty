<template>
    <div>
        <snackbar></snackbar>
        <v-dialog fullscreen v-model="showInscribeToGroupEvent" transition="dialog-bottom-transition"
                  :overlay="false"
                  scrollable>
           <group
                    :users="this.users"
                    :event="currentEvent"
                    @close="closeRegisterGroupDialog"
                    :dialog="true"
            ></group>
        </v-dialog>
        <v-card>
            <v-card-title class="primary darken-3 white--text"><h2>Events</h2></v-card-title>
            <v-card-text class="px-0 mb-2 hidden-sm-and-down">
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
                            <td class="text-xs-left"><a @click.stop="return;" :href="props.item.regulation" target="_blank">Reglament</a></td>
                            <td class="text-xs-right d-flex" >
                                <v-progress-circular v-if="props.item.loading" indeterminate color="primary"></v-progress-circular>
                                <v-switch v-else
                                          :input-value="props.item.inscribed"
                                          @change="toogleInscription(props.item)"
                                          :disabled="props.item.available_tickets < 1 && !props.item.inscribed"></v-switch>
                                <!--<v-btn flat icon color="success" v-if="props.item.leading" @click="editGroupRegistration">-->
                                    <!--<v-icon>mode_edit</v-icon>-->
                                <!--</v-btn>-->
                            </td>
                        </tr>
                    </template>
                    <template slot="expand" slot-scope="props">
                        <v-card>
                            <v-card-text>
                                <v-list two-line v-if="props.item.inscription_type_id == 1">
                                    <template v-if="props.item.groups && props.item.groups.length">
                                        <v-list-group
                                                v-for="(group, index) in props.item.groups"
                                                :key="group.id"
                                                no-action
                                        >
                                            <v-list-tile slot="activator">
                                                <v-list-tile-avatar>
                                                    <img :src="'/group/' + group.id + '/avatar'">
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>
                                                        <b>{{ group.name }}</b>
                                                    </v-list-tile-title>
                                                </v-list-tile-content>
                                                <!--<v-list-tile-action v-if="canEditGroup(group)">-->
                                                    <!--<v-btn icon ripple @click.stop="editGroup(group)">-->
                                                        <!--<v-icon color="success darken-1">mode_edit</v-icon>-->
                                                    <!--</v-btn>-->

                                                <!--</v-list-tile-action>-->
                                                <v-list-tile-action v-if="canDeleteGroup(group)">
                                                    <v-btn icon ripple @click.stop="unsubscribeGroup(props.item,group)">
                                                        <v-icon color="red darken-1">delete</v-icon>
                                                    </v-btn>
                                                </v-list-tile-action>
                                                <!--<v-list-tile-action v-if="memberOf(group,this.user)">-->
                                                    <!--<v-btn icon ripple @click.stop="unregisterToEvent(props.item)">-->
                                                        <!--<v-icon color="red darken-1">exit_to_app</v-icon>-->
                                                    <!--</v-btn>-->
                                                <!--</v-list-tile-action>-->
                                            </v-list-tile>

                                            <template v-if="group.members &&  group.members.length">
                                                <v-list-tile v-for="(member, index) in group.members" :key="member.id">
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>
                                                            {{index +1}}) {{member.sn1}} {{member.sn2}}, {{member.givenName}} <span class="hidden-sm-and-down">({{member.name}} - {{member.email}} )</span>
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                </v-list-tile>
                                            </template>
                                            <v-list-tile v-else>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>
                                                        Sense membres assignats al grup
                                                    </v-list-tile-title>
                                                </v-list-tile-content>
                                            </v-list-tile>

                                        </v-list-group>
                                    </template>
                                    <template v-else>
                                        Cap grup inscrit a l'esdeveniment
                                    </template>
                                </v-list>

                                <v-list two-line v-else>
                                    <template v-if="props.item.users && props.item.users.length">
                                        <template v-for="(user, index) in props.item.users">
                                            <v-list-tile avatar :key="user.title" @click="">
                                                <v-list-tile-avatar>
                                                    <img :src="gravatarURL(user.email)">
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>
                                                      <span v-if="user.givenName && (user.sn1 || user.sn2)">{{user.sn1}} {{user.sn2}} , {{user.givenName}}</span>
                                                     <span class="hidden-sm-and-down">({{user.name}})</span></v-list-tile-title>
                                                    <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                                                </v-list-tile-content>
                                                <v-list-tile-action v-if="canDeleteUser(user)">
                                                    <v-btn icon ripple @click.stop="unsubscribeUser(props.item,user)">
                                                        <v-icon color="red darken-1">delete</v-icon>
                                                    </v-btn>
                                                </v-list-tile-action>
                                            </v-list-tile>
                                        </template>
                                    </template>
                                    <template v-else>
                                        Cap usuari inscrit a l'esdeveniment
                                    </template>
                                </v-list>
                            </v-card-text>
                        </v-card>
                    </template>
                </v-data-table>
            </v-card-text>


            <v-expansion-panel>
                <v-data-iterator
                        content-tag="v-layout"
                        row
                        wrap
                        :items="internalEvents"
                        class="hidden-md-and-up"
                        hide-actions
                >
                    <v-expansion-panel-content
                            slot="item"
                            slot-scope="props">

                        <v-card slot="header" class="mb-1 mt-1">
                            <v-container fluid grid-list-lg>
                                <v-layout row>
                                    <v-flex xs7>
                                        <div>
                                            <div class="headline">{{ props.item.name }}</div>
                                            <v-layout row>
                                                <v-flex xs8>
                                                    <div class="text-xs-left">
                                                        Tipus:
                                                        <template v-if="props.item.inscription_type_id == 1">
                                                            Grup
                                                        </template>
                                                        <template v-else>
                                                            Individual
                                                        </template>
                                                    </div>
                                                </v-flex>
                                                <v-flex xs4>
                                                    Inscrit:
                                                    <v-progress-circular v-if="props.item.loading" indeterminate color="primary"></v-progress-circular>
                                                    <v-switch v-else
                                                              :input-value="props.item.inscribed"
                                                              @change="toogleInscription(props.item)"
                                                              :disabled="props.item.available_tickets < 1 && !props.item.inscribed"></v-switch>


                                                    <v-btn flat icon color="success" v-if="props.item.leading" @click="editGroupRegistration">
                                                        <v-icon>mode_edit</v-icon>
                                                    </v-btn>

                                                </v-flex>
                                            </v-layout>

                                            <div class="text-xs-left">Places: {{ props.item.tickets }}</div>
                                            <div class="text-xs-left">Inscrits: {{ props.item.assigned_tickets }}</div>
                                            <div class="text-xs-left">Disponibles: {{ props.item.available_tickets }}</div>
                                            <div class="text-xs-left"><a @click.stop="return;" :href="props.item.regulation" target="_blank">Reglament</a></div>
                                        </div>
                                    </v-flex>
                                    <v-flex xs5>
                                        <v-img
                                                :src="props.item.image"
                                                height="125px"
                                                contain
                                        ></v-img>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>

                        <v-card>
                            <v-card-text>
                                <template v-if="props.item.inscription_type_id == 1">
                                    <v-list two-line v-if="props.item.groups && props.item.groups.length">
                                            <v-list-group
                                                    v-for="(group, index) in props.item.groups"
                                                    :key="group.id"
                                                    no-action
                                            >
                                                <v-list-tile slot="activator">
                                                    <v-list-tile-avatar>
                                                        <img :src="'/group/' + group.id + '/avatar'">
                                                    </v-list-tile-avatar>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>
                                                            <b>{{ group.name }}</b>
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                    <!--<v-list-tile-action v-if="canEditGroup(group)">-->

                                                        <!--<v-btn icon ripple @click.stop="editGroup(group)">-->
                                                            <!--<v-icon color="success darken-1">mode_edit</v-icon>-->
                                                        <!--</v-btn>-->

                                                    <!--</v-list-tile-action>-->
                                                    <v-list-tile-action v-if="canDeleteGroup(group)">
                                                        <v-btn icon ripple @click.stop="unsubscribeGroup(props.item,group)">
                                                            <v-icon color="error darken-1">delete</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                                    <!--<v-list-tile-action v-if="memberOf(group,this.user)">-->
                                                        <!--<v-btn icon ripple @click.stop="unregisterToEvent(props.item)">-->
                                                            <!--<v-icon color="red darken-1">exit_to_app</v-icon>-->
                                                        <!--</v-btn>-->
                                                    <!--</v-list-tile-action>-->
                                                </v-list-tile>

                                                <template v-if="group.members &&  group.members.length">
                                                    <v-list-tile v-for="(member, index) in group.members" :key="member.id">
                                                        <v-list-tile-content>
                                                            <v-list-tile-title>
                                                                {{index +1}}) {{member.sn1}} {{member.sn2}}, {{member.givenName}} <span class="hidden-sm-and-down">({{member.name}})</span>
                                                            </v-list-tile-title>
                                                        </v-list-tile-content>
                                                    </v-list-tile>
                                                </template>
                                                <v-list-tile v-else>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>
                                                            Sense membres assignats al grup
                                                        </v-list-tile-title>
                                                    </v-list-tile-content>
                                                </v-list-tile>

                                            </v-list-group>
                                        </v-list>
                                    <template v-else>
                                        Cap grup inscrit a l'esdeveniment
                                    </template>
                                </template>
                                <template v-else>
                                    <v-list two-line>
                                        <template v-if="props.item.users && props.item.users.length">
                                            <template v-for="(user, index) in props.item.users">
                                                <v-list-tile avatar :key="user.title" @click="">
                                                    <v-list-tile-avatar>
                                                        <img :src="gravatarURL(user.email)">
                                                    </v-list-tile-avatar>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>{{user.sn1}} {{user.sn2}} , {{user.givenName}} <span class="hidden-sm-and-down">({{user.name}})</span></v-list-tile-title>
                                                        <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action v-if="canDeleteUser(user)">
                                                        <v-btn icon ripple @click.stop="unsubscribeUser(props.item,user)">
                                                            <v-icon color="red darken-1">delete</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                                </v-list-tile>
                                            </template>
                                        </template>
                                        <template v-else>
                                            Cap usuari inscrit a l'esdeveniment
                                        </template>
                                    </v-list>
                                </template>
                            </v-card-text>
                        </v-card>
                    </v-expansion-panel-content>
                </v-data-iterator>


            </v-expansion-panel>

        </v-card>
    </div>
</template>

<script>
  import InteractsWithGravatar from './mixins/interactsWithGravatar'
  import Group from './GroupComponent.vue'
  import * as mutations from '../store/mutation-types'
  import * as actions from '../store/action-types'
  import { mapGetters } from 'vuex'

  const GROUP = 1

  export default {
    name: 'Events',
    components: { Group },
    mixins: [InteractsWithGravatar],
    data () {
      return {
        showInscribeToGroupEvent: false,
        currentEvent: {},
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
      },
      users: {
        type: Array
      }
    },
    computed: {
      ...mapGetters({
        internalEvents: 'events',
        user: 'user',
        roles: 'roles'
      })
    },
    methods: {
      canEditGroup (group) {
        return (group.leader && group.leader.id === this.user.id) || this.loggedUserIsManager()
      },
      canDeleteGroup (group) {
        return (group.leader && group.leader.id === this.user.id) || this.loggedUserIsManager()
      },
      canDeleteUser (user) {
        return this.loggedUserIsManager()
      },
      loggedUserIsManager () {
        const found = this.roles.find((role) => {
          return role === 'Manager'
        })
        if (found) return true
        return false
      },
      editGroupRegistration () {
        this.avoidExpand = true
        this.showInscribeToGroupEvent = true
        // TODO Vuex store: logged user with groups is member. Use this data to fill fields on Group REgistration Form
      },
      closeRegisterGroupDialog () {
        this.showInscribeToGroupEvent = false
      },
      memberOf (group, user) {
        return group.members.find((member) => {
          return member.id === user.id
        })
      },
      editGroup (group) {
        // TODO
        console.log('TODO EDIT GROUP')
      },
      unsubscribeGroup (event, group) {
        this.$store.dispatch(actions.UNREGISTER_GROUP_TO_EVENT, {event, group}).then(() => {
          this.$store.commit(mutations.REMOVE_GROUP_FROM_EVENT, {event, group})
        })
      },
      unsubscribeUser (event, user) {
        this.$store.dispatch(actions.REMOVE_USER_FROM_EVENT, {user, event}).then(response => {
          this.$store.commit(mutations.REMOVE_USER_FROM_EVENT, {event, user})
        })
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
        if (event.inscription_type_id == GROUP) {  // eslint-disable-line
          this.showInscribeToGroupEvent = true
          this.currentEvent = event
        } else {
          this.$store.dispatch(actions.REGISTER_CURRENT_USER_TO_EVENT, {event, user: this.user})
        }
      },
      obtainGroup (event, user) {
        return event.groups.find((group) => {
          return group.members.find((member) => {
            return member.id === user.id
          })
        })
      },
      unregisterToEvent (event) {
        if (parseInt(event.inscription_type_id) === GROUP) {
          const group = this.obtainGroup(event, this.user)
          this.unsubscribeGroup(event, group)
        } else {
          this.$store.dispatch(actions.UNREGISTER_CURRENT_USER_TO_EVENT, {event, user: this.user})
        }
      }
    },
    created () {
      if (this.events) this.$store.commit(mutations.SET_EVENTS, this.events)
      else this.$store.dispatch(actions.FETCH_EVENTS)
    }
  }
</script>
