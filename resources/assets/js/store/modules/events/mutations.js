import * as types from '../../mutation-types'

export default {
  [ types.SET_EVENTS ] (state, events) {
    state.events = events
  }
}
