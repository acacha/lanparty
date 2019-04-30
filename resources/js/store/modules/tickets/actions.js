import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import tickets from '../../../api/tickets'

export default {
  [ actions.FETCH_TICKETS ] (context) {
    return new Promise((resolve, reject) => {
      tickets.fetch().then(response => {
        context.commit(mutations.SET_TICKETS, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
