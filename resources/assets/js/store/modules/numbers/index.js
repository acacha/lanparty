// import shop from '../../api/shop'

const state = {
  prova: []
}

const getters = {
  prova: state => state.prova
}

const actions = {
  prova ({ commit, state }, prova) {
    // TODO
    commit('prova', prova)
  }
}

const mutations = {
  prova (state, prova) {
    state.prova = prova
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}