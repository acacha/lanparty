<template>
  <span>
    <events-list :events="events"></events-list>
    <tasks-create v-show="dataTasks.length > 0" v-if="$can('user.tasks.store')" :users="users" @created="add" :uri="uri"></tasks-create>
  </span>
</template>
<script>
import EventsList from './EventsList'
import TasksCreate from './TasksCreate'

export default {
  name: 'EventsManage',
  components: {
    'events-list': EventsList,
    'tasks-create': TasksCreate
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  }
}

</script>
