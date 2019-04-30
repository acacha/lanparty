import * as types from '../../mutation-types'

export default {
  [ types.SELECTED_USER ] (state, user) {
    state.selected_user = user
  },
  [ types.SET_SELECTED_USER_NUMBERS ] (state, numbers) {
    state.selected_user.numbers = numbers
  },
  [ types.SET_SELECTED_USER_PAYMENT ] (state, {payment,session}) {
    console.log('SET_SELECTED_USER_PAYMENT!!!!!!!!!!!!')
    console.log('state.selected_user.inscription_paid:')
    console.log(state.selected_user.inscription_paid)
    console.log('rray.isArray(state.selected_user.inscription_paid):')
    console.log(Array.isArray(state.selected_user.inscription_paid))
    console.log('ERROR!!!!!!')
    console.log('state.selected_user.inscription_paid[session]:')
    console.log(state.selected_user.inscription_paid[session])
    if (!Array.isArray(state.selected_user.inscription_paid)) {
      console.log('setting to array!')
      state.selected_user.inscription_paid = []
    }
    console.log('state.selected_user.inscription_paid 2:')
    console.log(state.selected_user.inscription_paid)
    state.selected_user.inscription_paid[session] = payment
    console.log('state.selected_user.inscription_paid 3:')
    console.log(state.selected_user.inscription_paid)
  },
  [ types.SET_USER_PAYMENT_STATE ] (state, { user, payment, session }) {
    console.log('SET_USER_PAYMENT_STATE!!')
    var userFound = state.users.find((u) => {
      return u.id === user.id
    })
    console.log('userFound:')
    console.log(userFound)
    if (userFound) {
      console.log('userFound.inscription_paid:')
      console.log(userFound.inscription_paid)
      userFound.inscription_paid[session] = payment
      console.log('userFound.inscription_paid 2:')
      console.log(userFound.inscription_paid)
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
