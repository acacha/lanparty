<template>
  <v-form>
    <v-container
      fill-height
      fluid
      grid-list-xl
    >
      <v-layout
        justify-center
        wrap
      >
        <v-flex
          xs12
          md8
        >
        <v-text-field v-model="name"></v-text-field>
        <v-text-field v-model="category"></v-text-field>
        <session-select v-model="session"></session-select>
        </v-flex>
        <v-flex
          xs12
          md4
        >
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="150"
          >
            <img ref="partner_avatar"
                 src="https://3.bp.blogspot.com/-pxQONzCoagM/W_nddYu2U9I/AAAAAAAAJ3w/UD5KKwtzwnQwQy8a2DdFh2wFebsFOq5SACEwYBhgL/s1600/caa5a87b-16aa-4712-9d50-479919cb94.png"
            >
          </v-avatar>
        </v-flex>
      </v-layout>
    </v-container>
    <div class="text-xs-center">
      <v-btn @click="$emit('close')">
        <v-icon class="mr-1">exit_to_app</v-icon>
        Cancel·lar
      </v-btn>
      <v-btn color="success" @click="update" :disabled="loading" :loading="loading">
        <v-icon class="mr-1">save</v-icon>
        Modificar
      </v-btn>
    </div>
  </v-form>
</template>

<script>
import SessionSelect from '../SessionSelect'

export default {
  name: 'PartnerUpdateForm',
  components: {
    'session-select': SessionSelect
  },
  data () {
    return {
      name: this.partner.name,
      category: this.partner.category,
      session: this.partner.session,
      loading: false,
      uploading: false
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    update () {
      this.loading = true
      const newPartner = {
        name: this.name,
        category: this.category,
        session: this.session
      }
      window.axios.put(this.uri + this.partner.id, newPartner).then((response) => {
        this.$emit('updated', response.data)
        this.$emit('close')
        this.loading = false
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
