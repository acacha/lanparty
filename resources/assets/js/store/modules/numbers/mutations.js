import * as types from '../../mutation-types'

export default {
  [ types.LAST_ASSIGNED_NUMBER ] (state, number) {
    state.last_assigned_number = number
  },
  [ types.SET_NUMBERS ] (state, numbers) {
    state.numbers = numbers
  },
  [ types.ASSIGN_USER_TO_NUMBER ] (state, { user, number }) {
    var foundNumber = state.numbers.find((n) => {
      return n.id === number.id
    })
    foundNumber.user = user
    foundNumber.user_id = user
  },
  [ types.UNASSIGN_USER_TO_NUMBER ] (state, { user, number }) {
    var foundNumber = state.numbers.find((n) => {
      return n.id === number.id
    })
    foundNumber.user = {}
    foundNumber.user_id = null
  }
}
