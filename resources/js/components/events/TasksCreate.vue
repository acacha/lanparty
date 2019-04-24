<!--<template>-->
<!--    <span>-->
<!--        <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" hide-overlay transition="dialog-bottom-transition"-->
<!--                  @keydown.esc.stop.prevent="dialog=false">-->
<!--            <v-toolbar color="primary" class="white&#45;&#45;text">-->
<!--                <v-btn flat icon class="white&#45;&#45;text" @click="dialog=false">-->
<!--                    <v-icon class="mr-2">close</v-icon>-->
<!--                </v-btn>-->
<!--                <v-card-title class="headline">Crear tasca</v-card-title>-->
<!--                <v-spacer></v-spacer>-->
<!--                <v-btn flat class="white&#45;&#45;text" @click="dialog=false">-->
<!--                    <v-icon class="mr-2">exit_to_app</v-icon>-->
<!--                    Sortir-->
<!--                </v-btn>-->
<!--                <v-btn flat class="white&#45;&#45;text">-->
<!--                    <v-icon class="mr-2">save</v-icon>-->
<!--                    Guardar-->
<!--                </v-btn>-->
<!--            </v-toolbar>-->
<!--            <v-card>-->
<!--                <v-card-text>-->
<!--                    <task-form :users="users" @close="dialog=false" @created="created" :uri="uri"></task-form>-->
<!--                </v-card-text>-->
<!--            </v-card>-->
<!--        </v-dialog>-->
<!--        <v-btn fab bottom right color="secondary" fixed class="white&#45;&#45;text"-->
<!--               @click="dialog = true">-->
<!--            <v-icon>add</v-icon>-->
<!--        </v-btn>-->
<!--    </span>-->
<!--</template>-->

<!--<script>-->
<!--import TaskForm from './TaskForm'-->
<!--import EventBus from './../eventBus'-->
<!--export default {-->
<!--  name: 'TasksCreate',-->
<!--  components: {-->
<!--    'task-form': TaskForm-->
<!--  },-->
<!--  data () {-->
<!--    return {-->
<!--      dialog: false-->
<!--    }-->
<!--  },-->
<!--  props: {-->
<!--    users: {-->
<!--      type: Array,-->
<!--      required: true-->
<!--    },-->
<!--    uri: {-->
<!--      type: String,-->
<!--      required: true-->
<!--    }-->
<!--  },-->
<!--  methods: {-->
<!--    created (task) {-->
<!--      this.$emit('created', task)-->
<!--    }-->
<!--  },-->
<!--  mounted () {-->
<!--    EventBus.$on('cta', () => {-->
<!--      this.dialog = true-->
<!--    })-->
<!--  }-->
<!--}-->
<!--</script>-->
