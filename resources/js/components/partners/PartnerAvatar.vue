<template>
  <span>
    <v-tooltip bottom  v-if="partner.avatar">
                    <template v-slot:activator="{ on }">
                      <v-avatar v-on="on">
                        <img :src="partner.avatar">
                      </v-avatar>
                    </template>
                    <span>{{partner.name}}</span>
                  </v-tooltip>
    <v-tooltip bottom v-else>
                    <template v-slot:activator="{ on }">
                        <v-avatar v-on="on">
                      <img src="/img/logos/defaultAvatarPartner/defaultPartner.png">
                    </v-avatar>
                    </template>
                    <span>{{partner.name}}</span>
                  </v-tooltip>
  </span>
</template>

<script>
export default {
  name: 'PartnerAvatar',
  props: {
    partner: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>

</style>
