<template>
    <v-autocomplete
            v-model="internalPrize"
            :items="internalPrizes"
            label="Seleccioneu un regal o indiqueu un de nou"
            item-value="name"
            item-text="name"
            combobox
            chips
            clearable
            no-data-text="No hi ha cap premi disponible"
            :loading="loading"
            :return-object="returnObject"
    >
        <template slot="selection" slot-scope="data">
            <v-chip
                    :key="JSON.stringify(data.item)"
                    class="chip--select-multi"
            >
                {{ data.item.name }}
            </v-chip>
        </template>
        <template slot="item" slot-scope="data">
            <v-list-tile-content>
                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                <v-list-tile-sub-title> {{ data.item.partner && data.item.partner.name }} | {{ data.item.session }} </v-list-tile-sub-title>
            </v-list-tile-content>
        </template>
    </v-autocomplete>
</template>

<script>
export default {
  name: 'PrizesSelect',
  data () {
    return {
      internalPrizes: this.prizes,
      internalPrize: null
    }
  },
  model: {
    prop: 'prize',
    event: 'input'
  },
  props: {
    prizes: {
      type: Array,
      required: true
    },
    prize: {},
    loading: {
      type: Boolean,
      default:false
    },
    returnObject: {
      type: Boolean,
      default:true
    }
  },
  watch: {
    prize(prize) {
      this.internalPrize = prize
    },
    prizes(prizes) {
      this.internalPrizes = prizes
    },
    internalPrize(internalPrize) {
      this.$emit('input', internalPrize)
    }
  }
}
</script>
