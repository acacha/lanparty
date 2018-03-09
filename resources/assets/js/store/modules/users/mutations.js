import * as types from '../../mutation-types'

export default {
  [ types.SELECTED_USER ] (state, user) {
    state.selected_user = user
  },
  [ types.SET_SELECTED_USER_NUMBERS ] (state, numbers) {
    state.selected_user.numbers = numbers
  },
  [ types.SET_SELECTED_USER_PAYMENT ] (state, payment) {
    state.selected_user.inscription_paid = payment
  },
  [ types.SET_USER_PAYMENT_STATE ] (state, { user, payment }) {
    var userFound = state.users.find((u) => {
      return u.id === user.id
    })
    userFound.inscription_paid = payment
  },
  [ types.ADD_NUMBER_TO_SELECTED_USER_NUMBERS ] (state, number) {
    state.selected_user.numbers.push(number)
  },
  [ types.REMOVE_NUMBER_TO_SELECTED_USER_NUMBERS ] (state, number) {
    state.selected_user.numbers.splice(state.selected_user.numbers.indexOf(number), 1)
  },
  [ types.SET_USERS ] (state, users) {
    state.users = users
  },
  [ types.UNREGISTER_SELECTED_USER_TO_EVENT ] (state, event) {
    state.selected_user.events.splice(state.selected_user.events.indexOf(event), 1)
  },
  [ types.REGISTER_SELECTED_USER_TO_EVENT ] (state, event) {
    state.selected_user.events.push(event)
  },
  [ types.SET_SELECTED_USER_EVENTS ] (state, events) {
    state.selected_user.events = events
  }
}
