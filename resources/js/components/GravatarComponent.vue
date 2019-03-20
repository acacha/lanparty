<template>
    <v-avatar class="mt-1 mb-1" :size="size" @click="$emit('click')">
        <img :src="gravatarURL(user.email)" alt="avatar">
    </v-avatar>
</template>

<style>

</style>

<script>
import interactsWithGravatar from './mixins/interactsWithGravatar'

export default {
  name: 'Gravatar',
  mixins: [ interactsWithGravatar ],
  props: {
    user: {
      type: Object,
      required: false
    },
    size: {
      type: String,
      default: '100px'
    }
  },
}
</script>
