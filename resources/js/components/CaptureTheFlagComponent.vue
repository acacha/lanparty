<template>
    <v-card>
        <v-card-title class="white--text">
            <h2>Rànquing CTF INSEbre</h2>
        </v-card-title>
        <v-card-text class="px-0 mb-2">
            <v-data-table
              :headers="headers"
              :items="groups"
              hide-actions
              class="ctfTable"
            >
              <template v-slot:headers>
                  <th
                    v-for="header in headers"
                    :key="header.text"
                    class="ctfTable"
                  >
                    {{ header.text }}
                  </th>
              </template>
              <template v-slot:items="props">
                <tr>
                  <td>{{ props.index +1 }}</td>
                  <td>{{ props.item.points }}</td>
                  <td><a :href="'/ctfGroup/' +props.item.id">{{ props.item.name }}</a></td>
                  <td v-for="flag in props.item.flags">
                      <img v-if="flag==true" src="/img/green.png" class="flagImg">
                      <img v-else src="/img/red.png" class="flagImg">
                  </td>
                </tr>
              </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<style scoped>@import 'ctf.scss';</style>

<script>
  export default {
    data () {
      return {
        headers: [
          { text: 'Ranking', value: 'ranking' },
          { text: 'Points', value: 'points' },
          { text: 'Team', value: 'team' },
          { text: 'F1', value: 'f1' },
          { text: 'F2', value: 'f2' },
          { text: 'F3', value: 'f3' },
          { text: 'F4', value: 'f4' },
          { text: 'F5', value: 'f5' },
          { text: 'F6', value: 'f6' },
          { text: 'F7', value: 'f7' },
          { text: 'F8', value: 'f8' },
          { text: 'F9', value: 'f9' }
        ]
      }
    },
    props: {
      groups: {
        type: Array,
        required: true
      }
    }
  }
</script>
