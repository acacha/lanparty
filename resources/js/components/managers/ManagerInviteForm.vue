<template>
    <form>
        <v-text-field
                label="Email de l'usuari a invitar"
                v-model="name"
                :rules="nameRules"
                :counter="50"
                required
        ></v-text-field>
    </form>
</template>

<script>
export default {
 name: 'ManagerInviteForm',

}
</script>
