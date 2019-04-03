<template>
  <span>
    <events-list></events-list>
  </span>
</template>
<script>
import EventsList from './EventsList'
export default {
  name: 'Events',
  components: {
    'events-list': EventsList
  }

}

</script>
