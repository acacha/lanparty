import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import auth from '../../../api/auth'

export default {
  [ actions.LOGIN ] (context, credentials) {
    return new Promise((resolve, reject) => {
      auth.login(credentials).then(response => {
        context.commit(mutations.LOGGED, true)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
