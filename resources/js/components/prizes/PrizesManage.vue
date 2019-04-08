<template>
  <span>
    <prizes-list></prizes-list>
    <prizes-create></prizes-create>
  </span>
</template>

<script>
    import PrizesList from "./PrizesList";
    import PrizesCreate from "./PrizesCreate";

    export default {
        name: "PrizesManage",
      components:{
          'prizes-list':PrizesList,
        'prizes-create':PrizesCreate
      }
    }
</script>

<style scoped>

</style>
