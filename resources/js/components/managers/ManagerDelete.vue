<template>
    <v-tooltip top>
        <v-btn slot="activator" icon flat color="error" :loading="loading" :disabled="loading" @click="remove" >
            <v-icon>delete</v-icon>
        </v-btn>
        <span>Treure el rol de Manager a l'usuari</span>
    </v-tooltip>
</template>

<script>
export default {
  name: 'ManagerDelete',
  data () {
    return {
      loading: false
    }
  },
  props: {
    manager: {
      type: Object,
      required: true
    }
  },
  methods: {
    remove() {
      this.loading = true
      window.axios.delete('/api/v1/user/' + this.manager.id + '/manager').then(() => {
        this.loading = false
        this.$snackbar.showMessage("S'ha tret el rol de manager a l'usuari");
        this.$emit('deleted')
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
