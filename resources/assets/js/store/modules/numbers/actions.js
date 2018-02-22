import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import numbers from '../../../api/numbers'

export default {
  [ actions.ASSIGN_NUMBER_TO_USER ] (context, user) {
    return new Promise((resolve, reject) => {
      numbers.fetch(user).then(response => {
        context.commit(mutations.LAST_ASSIGNED_NUMBER, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
