<template>
  <span>
    <events-list :events="events"></events-list>
  </span>
</template>
<script>
import EventsList from './EventsList'
export default {
  name: 'EventsManage',
  components: {
    'events-list': EventsList
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  }
}

</script>
