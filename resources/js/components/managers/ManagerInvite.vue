<template>
    <v-card>
        <v-card-text>
            <manager-invite-form :users="users"></manager-invite-form>
        </v-card-text>
    </v-card>
</template>

<script>
import ManagerInviteForm from './ManagerInviteForm'
export default {
  name: 'ManagerInvite',
  components: {
    'manager-invite-form': ManagerInviteForm
  },
  props: {
    users: {
      type: Array,
      required: true
    }
  }
}
</script>
