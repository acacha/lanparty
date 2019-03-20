<template>
    <v-toolbar
            color="primary darken-3"
            dark
            app
            clipped-left
            clipped-right
            fixed
    >
        <v-toolbar-title :style="$vuetify.breakpoint.smAndUp ? 'width: 300px; min-width: 250px' : 'min-width: 72px'" class="ml-0 pl-3">
            <v-toolbar-side-icon @click.stop.prevent="$emit('toggleleft')"></v-toolbar-side-icon>
            <span class="hidden-xs-only">{{ title }}</span>
        </v-toolbar-title>
        <div class="d-flex align-center" style="margin-left: auto">
            <gravatar @click="$emit('toggleright')" :user="user" size="52px"></gravatar>
        </div>
    </v-toolbar>
</template>

<script>

import Gravatar from '../GravatarComponent.vue'

export default {
  name: 'MainToolbar',
  components: {
    'gravatar': Gravatar
  },
  props: {
    title: {
      type: String,
      default: 'Posa el teu títol aquí'
    }
  },
  created () {
    this.user = window.user
  }
}
</script>
