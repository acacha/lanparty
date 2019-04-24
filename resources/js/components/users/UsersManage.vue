<template>
    <v-container grid-list-md fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <users-list :users="users"></users-list>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import UsersList from './UsersList'
export default {
  name: 'UsersManage',
  components: {
    'users-list': UsersList
  },
  props: {
    users: {
      type: Array,
      required: true
    }
  }
}
</script>
