import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import numbers from '../../../api/numbers'

export default {
  [ actions.ASSIGN_NUMBER_TO_USER ] (context, { user, description, session }) {
    return new Promise((resolve, reject) => {
      numbers.assignNumberToUser(user, description, session).then(response => {
        context.commit(mutations.LAST_ASSIGNED_NUMBER, response.data)
        context.commit(mutations.ASSIGN_USER_TO_NUMBER, { user, number: response.data })
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.UNASSIGN_NUMBER_TO_USER ] (context, number) {
    return new Promise((resolve, reject) => {
      numbers.unassignNumberToUser(number).then(response => {
        context.commit(mutations.UNASSIGN_USER_TO_NUMBER, { user: number.user, number })
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.UNASSIGN_NUMBERS_TO_USER ] (context, user) {
    return new Promise((resolve, reject) => {
      numbers.unassignNumbersToUser(user).then(response => {
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.FETCH_NUMBERS ] (context) {
    return new Promise((resolve, reject) => {
      numbers.fetch().then(response => {
        context.commit(mutations.SET_NUMBERS, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
