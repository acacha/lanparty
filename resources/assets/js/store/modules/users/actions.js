import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import users from '../../../api/users'

export default {
  [ actions.SELECTED_USER ] (context, user) {
    context.commit(mutations.SELECTED_USER, user)
  },
  [ actions.FETCH_USERS ] (context) {
    return new Promise((resolve, reject) => {
      users.fetch().then(response => {
        context.commit(mutations.SET_USERS, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.USER_PAY ] (context, user) {
    return new Promise((resolve, reject) => {
      users.pay(user).then(response => {
        context.commit(mutations.SET_SELECTED_USER_PAYMENT, true)
        context.commit(mutations.SET_USER_PAYMENT_STATE, {user, payment: true})
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.USER_UNPAY ] (context, user) {
    return new Promise((resolve, reject) => {
      users.unpay(user).then(response => {
        context.commit(mutations.SET_SELECTED_USER_PAYMENT, false)
        context.commit(mutations.SET_USER_PAYMENT_STATE, {user, payment: false})
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
