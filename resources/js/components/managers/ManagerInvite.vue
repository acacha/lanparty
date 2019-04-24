<template>
    <v-card>
        <v-card-text>
            <manager-invite-form></manager-invite-form>
        </v-card-text>
    </v-card>
</template>

<script>
import ManagerInviteForm from './ManagerInviteForm'
export default {
  name: 'ManagerInvite',
  components: {
    'manager-invite-form': ManagerInviteForm
  }
}
</script>
