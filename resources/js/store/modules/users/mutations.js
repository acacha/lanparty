import * as types from '../../mutation-types'

export default {
  [ types.SELECTED_USER ] (state, user) {
    state.selected_user = user
  },
  [ types.SET_SELECTED_USER_NUMBERS ] (state, numbers) {
    state.selected_user.numbers = numbers
  },
  [ types.SET_SELECTED_USER_PAYMENT ] (state, {payment,session}) {
    console.log('state.selected_user.inscription_paid:')
    console.log(state.selected_user.inscription_paid)
    console.log('session:')
    console.log(session)
    console.log('payment:')
    console.log(payment)
    // https://vuejs.org/v2/guide/list.html#Caveats
    // Utilitza 2019 com a index!!! en comptes com array associatiu
    window.Vue.prototype.$set(state.selected_user.inscription_paid, session, payment)
  },
  [ types.SET_USER_PAYMENT_STATE ] (state, { user, payment, session }) {
    var userFound = state.users.find((u) => {
      return u.id === user.id
    })
    if (userFound) {
      window.Vue.prototype.$set(userFound.inscription_paid, session, payment)
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
