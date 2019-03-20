<template>
    <v-card>
        <v-card-title class="primary darken-3 white--text"><h2>Números del sorteig</h2></v-card-title>
        <v-card-text class="px-0 mb-2">
            <v-list subheader v-if="user.numbers.length > 0">
                <v-tooltip v-for="number in user.numbers" :key="number.id" top>
                    <v-chip :color="randomColor()" text-color="white" slot="activator">
                        {{ number.value }}
                        <v-icon right>star</v-icon>
                    </v-chip>
                    <span>Motiu: {{ number.description || 'cap motiu especificat' }}</span>
                </v-tooltip>
            </v-list>
            <v-alert v-else color="info" icon="info" :value="true" class="mx-2">
                Encara no tens cap número de sorteig assignat
            </v-alert>
        </v-card-text>
    </v-card>
</template>

<style>

</style>

<script>
  import { mapGetters } from 'vuex'
  import randomColor from './mixins/randomColor'

  export default {
    name: 'UserNumbers',
    mixins: [randomColor],
    computed: {
      ...mapGetters([
        'user'
      ])
    }
  }
</script>
