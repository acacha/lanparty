import * as types from '../../mutation-types'

export default {
  [ types.LOGGED ] (state, logged) {
    state.logged = logged
  }
}
