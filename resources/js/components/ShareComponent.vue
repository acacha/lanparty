<template>
    <div>
        <v-btn v-if="show"
               fab
               bottom
               right
               color="pink"
               dark
               fixed
               @click="share"
        >
            <v-icon>share</v-icon>
        </v-btn>

        <v-speed-dial
                :bottom="true"
                :right="true"
                direction="top"
                v-else
                fixed
        >
            <v-btn
                    slot="activator"
                    color="primary darken-2"
                    dark
                    fab
                    hover
            >
                <v-icon>share</v-icon>
                <v-icon>close</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="success"
            >
                <v-icon>edit</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="indigo"
            >
                <v-icon>add</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="red"
            >
                <v-icon>delete</v-icon>
            </v-btn>
        </v-speed-dial>
    </div>
</template>

<style>

</style>

<script>
  export default {
    name: 'Share',
    data () {
      return {
        data: 'example',
        show: false
      }
    },
    methods: {
      share () {
        navigator.share({
          title: 'My awesome post!',
          text: 'This post may or may not contain the answer to the universe',
          url: window.location.href
        }).then(() => {
          console.log('Thanks for sharing!')
        })
          .catch(err => {
            console.log(`Couldn't share because of`, err.message)
          })
      }
    },
    mounted () {
      if (navigator.share) this.show = true
    }
  }
</script>
