import * as types from '../../mutation-types'

export default {
  [ types.LAST_ASSIGNED_NUMBER ] (state, number) {
    state.last_assigned_number = number
  }
}
