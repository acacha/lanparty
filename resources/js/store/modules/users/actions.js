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
  [ actions.USER_PAY ] (context, {user, session} ) {
    return new Promise((resolve, reject) => {
      users.pay({user, session}).then(response => {
        context.commit(mutations.SET_SELECTED_USER_PAYMENT, {payment: true, session})
        context.commit(mutations.SET_USER_PAYMENT_STATE, {user, payment: true, session})
        context.dispatch(actions.FETCH_TICKETS)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.USER_UNPAY ] (context, { user, session } ) {
    return new Promise((resolve, reject) => {
      users.unpay({user, session}).then(response => {
        context.commit(mutations.SET_SELECTED_USER_PAYMENT, {payment: false, session})
        context.commit(mutations.SET_USER_PAYMENT_STATE, {user, payment: false, session})
        context.dispatch(actions.FETCH_TICKETS)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.UPDATE_USER ] (context, user) {
    return new Promise((resolve, reject) => {
      users.update(user).then(response => {
        context.commit(mutations.USER, user)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
