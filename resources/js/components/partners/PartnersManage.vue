<template>
  <span>
    <partners-list></partners-list>
    <partner-create></partner-create>
    </span>
</template>

<script>
import PartnersList from './PartnersList'
import PartnerCreate from "./PartnerCreate";

export default {
  name: 'PartnersManage',
  components: {
    'partners-list': PartnersList,
    'partner-create': PartnerCreate
  },
  data (){
    return {
      dataPartners: this.partners
    }
  },

}
</script>
