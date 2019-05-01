<template>
    <v-card>
        <v-card-title class="white--text">
            <h2>Flags capturades per {{ groupName }}</h2>
        </v-card-title>
        <v-card-text class="px-0 mb-2">
            <v-data-table
              :headers="headers"
              :items="flags"
              hide-actions
              class="ctfTable"
            >
              <template v-slot:headers>
                  <th
                    v-for="header in headers"
                    :key="header.text"
                    class="ctfTableHead"
                  >
                    {{ header.text }}
                  </th>
              </template>
              <template v-slot:items="props">
                <tr>
                  <td>{{ props.item.name }}</td>
                  <td>{{ props.item.points }}</td>
                  <td >{{ props.item.pivot.captured }}</td>
                </tr>
              </template>
            </v-data-table>
        </v-card-text>
        <v-card-title class="ctfBack">
                <v-btn icon href="/ctf">
                  <v-icon>flag</v-icon> Ranquing
                </v-btn>
        </v-card-title>
    </v-card>
</template>

<style scoped>@import 'ctf.scss';</style>

<script>
  export default {
    data () {
      return {
        headers: [
          { text: 'Flag', value: 'flag' },
          { text: 'Points', value: 'points' },
          { text: 'Captured', value: 'captured' }
        ]
      }
    },
    props: {
      flags: {
        type: Array,
        required: true
      },
      groupName: {
        type: String,
        required: true
      }
    }
  }
</script>
