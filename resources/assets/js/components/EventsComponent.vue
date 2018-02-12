<template>
    <v-card>
        <v-card-title class="blue darken-3 white--text"><h2>Events</h2></v-card-title>
        <v-card-text class="px-0 mb-2">
            <v-list>
                <v-list-tile avatar @click="" v-for="event in events" :key="event.id" >
                    <v-list-tile-avatar :tile="true">
                        <v-avatar>
                            <img :src="event.image">
                        </v-avatar>
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            {{ event.name }}
                            <template v-if="event.inscription_type_id == 1">
                                ( Competició en grup )
                            </template>
                            <template v-else>
                                ( Competició individual )
                            </template>
                        </v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                        <v-list-tile-action-text>Inscrit</v-list-tile-action-text>
                        <v-icon>done</v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<style>

</style>

<script>
  export default {
    name: 'Events',
    props: {
      events: {
        type: Array,
        required: true
      }
    },
    methods: {
      toogleRegisterToEvent () {
        console.log('TODOOOOOOOOOOOOO')
      }
    }
  }
</script>
