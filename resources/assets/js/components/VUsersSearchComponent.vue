<template>
    <v-container fluid grid-list-sm>
        <v-layout row wrap>
            <v-flex xs12>
                <v-select
                        :label="label"
                        :items="users"
                        v-model="selected_user_id"
                        item-text="full_search"
                        max-height="auto"
                        autocomplete
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
                                <img :src="gravatarURL(data.item.email)">
                            </v-avatar>
                            {{ data.item.name }} | {{ data.item.email }}
                        </v-chip>
                    </template>
                    <template slot="item" slot-scope="data">
                        <template v-if="typeof data.item !== 'object'">
                            <v-list-tile-content v-text="data.item"></v-list-tile-content>
                        </template>
                        <template v-else>
                            <v-list-tile-avatar>
                                <img v-bind:src="gravatarURL(data.item.email)"/>
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title>{{data.item.name}} | {{ data.item.givenName }} {{ data.item.sn1 }} {{ data.item.sn2 }}</v-list-tile-title>
                                <v-list-tile-sub-title>{{data.item.email}} | {{ data.item.formatted_created_at_date }}</v-list-tile-sub-title>
                            </v-list-tile-content>
                        </template>
                    </template>
                </v-select>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  export default {
    name: 'VUsersSearch',
    mixins: [ interactsWithGravatar ],
    data () {
      return {
        selected_user_id: null
      }
    },
    props: {
      users: {
        type: Array,
        required: false
      },
      label: {
        type: String,
        default: 'Seleccioneu un usuari'
      }
    },
    methods: {
      input (user) {
        this.$emit('input', user)
      }
    }
  }
</script>