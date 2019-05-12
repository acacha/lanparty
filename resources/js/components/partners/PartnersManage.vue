<template>
  <span>
    <partners-list :uri="uri" :partners="dataPartners" ></partners-list>
    <partner-create :uri="uri" @created="add"></partner-create>
    </span>
</template>

<script>
import PartnersList from './PartnersList'
import PartnerCreate from './PartnerCreate'

export default {
  name: 'PartnersManage',
  components: {
    'partners-list': PartnersList,
    'partner-create': PartnerCreate
  },
  data () {
    return {
      dataPartners: this.partners
    }
  },
  props: {
    partners: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    add (partner) {
      this.dataPartners.push(partner)
    }
  }

}
</script>
