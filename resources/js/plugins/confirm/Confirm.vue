<!-- // Taken from https://github.com/yariksav/vuetify-confirm -->
<template>
  <v-dialog @input="change" value="true" :max-width="width">
    <v-toolbar v-if="!!title" dark :color="color" dense>
      <v-icon v-if="!!icon">{{ icon }}</v-icon>
      <v-toolbar-title class="white--text" v-text="title"/>
    </v-toolbar>
    <v-card tile>
      <v-card-text v-html="message"/>
      <v-card-actions>
        <v-spacer/>
        <v-btn :color="buttonFalseColor" flat @click="choose(false)">{{ buttonFalseText }}</v-btn>
        <v-btn :color="buttonTrueColor" @click="choose(true)">{{ buttonTrueText }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>

export default {
  props: {
    buttonTrueText: {
      type: String,
      default: 'Confirmar'
    },
    buttonFalseText: {
      type: String,
      default: 'Cancel·lar'
    },
    buttonTrueColor: {
      type: String,
      default: 'error'
    },
    buttonFalseColor: {
      type: String,
      default: 'primary'
    },
    color: {
      type: String,
      default: 'warning'
    },
    icon: {
      type: String,
      default: 'warning'
    },
    message: {
      type: String,
      reqiured: true
    },
    title: {
      type: String
    },
    width: {
      type: Number,
      default: 300
    }
  },
  data () {
    return {
      value: false
    }
  },
  methods: {
    choose (value) {
      this.$emit('result', value)
      this.value = value
      this.$destroy()
    },

    change (res) {
      this.$destroy()
    }
  }
}
</script>
