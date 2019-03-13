import getters from './getters'
import actions from './actions'
import mutations from './mutations'

const state = {
  last_assigned_number: {},
  numbers: []
}

export default {
  state,
  getters,
  actions,
  mutations
}
