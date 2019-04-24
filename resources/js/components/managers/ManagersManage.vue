<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12>
                <manager-invite :users="users"></manager-invite>
            </v-flex>
            <v-flex xs12>
                <managers-list :managers="managers"></managers-list>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import ManagersList from './ManagersList'
import ManagerInvite from './ManagerInvite'
export default {
  name: 'ManagersManage',
  components: {
    'manager-invite': ManagerInvite,
    'managers-list': ManagersList
  },
  props: {
    managers: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  }
}
</script>
