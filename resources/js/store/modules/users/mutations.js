import * as types from '../../mutation-types'

export default {
  [ types.SELECTED_USER ] (state, user) {
    state.selected_user = user
  },
  [ types.SET_SELECTED_USER_NUMBERS ] (state, numbers) {
    state.selected_user.numbers = numbers
  },
  [ types.SET_SELECTED_USER_PAYMENT ] (state, {payment,session}) {
    if (payment) {
      if (!state.selected_user.inscription_paid.includes(session)) {
        state.selected_user.inscription_paid.push(session)
      }
    } else {
      if (state.selected_user.inscription_paid.includes(session)) {
        state.selected_user.inscription_paid.splice(session,1)
        state.selected_user.inscription_paid.splice(state.selected_user.inscription_paid.indexOf(session), 1)
      }
    }

  },
  [ types.SET_USER_PAYMENT_STATE ] (state, { user, payment, session }) {
    var userFound = state.users.find((u) => {
      return u.id === user.id
    })
    if (userFound) {
      if (payment) {
        if (!userFound.inscription_paid.includes(session)) userFound.inscription_paid.push(session)
      } else if (userFound.inscription_paid.includes(session)) userFound.inscription_paid.splice(userFound.inscription_paid.indexOf(session), 1)
    }
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
