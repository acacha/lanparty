<template>
    <v-card>
        <v-card-title primary-title>
            <manager-invite-form></manager-invite-form>
        </v-card-title>
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
