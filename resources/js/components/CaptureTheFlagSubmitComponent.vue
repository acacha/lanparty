<template>
    <v-card class="" v-if="mostrar != 'NoRegistrat'">
        <v-card-text class="px-0 mb-2">
        	<div class="msg">
          Entra la cadena amb el Flag trobat. </br>
        	Si és correcte s'acumularan els punts del Flag. </br>
        	Reviseu d'enganxar TOTS els caràcters.
          </div>
        	<div class="msg">
        		<form  @submit.prevent="submit">
                <div class="form-group">
                    <label for="flag">Flags:</label>
                    <input type="text" class="form-control ctfInput" name="flag" id="flag" v-model="fields.flag" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Envia</button>
        		</form>
        	</div>
        </v-card-text>
      </v-card>
</template>

<style scoped>@import 'ctf.scss';</style>

<script>
  export default {
    data () {
      return {
        fields: {},
        errors: {},
        }
    },
    methods: {
      submit() {
        console.log(this.fields)
        this.errors = {};
        axios.post('/ctfSubmit', this.fields).then(response => {
            alert("Flag Capturat!!!");
            window.location.reload();
        }).catch(error => {
            if (error.response.status === 422) {
              console.log(error.response)
              this.errors = error.response.data.errors || {};
            }
        });
      }
    },
    props: {
      mostrar: {
        required: true
      }
    }
  }
</script>
