<template>
  <v-container grid-list-md text-xs-center fluid>
    <v-layout row wrap>
      <v-flex xs12>
        <events-list :events="events"></events-list>
        <events-create @created="add"></events-create>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import EventsList from './EventsList'
import EventsCreate from './EventsCreate'

export default {
  name: 'EventsManage',
  data () {
    return {
      dataEvents: this.events,
    }
  },
  components: {
    'events-list': EventsList,
    'events-create': EventsCreate
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  },
  methods: {
    add (event) {
      this.dataEvents.push(event)
    }
  }
}

</script>
