<template>
  <span>
    <events-list :events="events"></events-list>
    <events-create @created="add"></events-create>
  </span>
</template>
<script>
import EventsList from './EventsList'
import EventsCreate from './EventsCreate'

export default {
  name: 'EventsManage',
  components: {
    'events-list': EventsList,
    'events-create': EventsCreate
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  }
}

</script>
