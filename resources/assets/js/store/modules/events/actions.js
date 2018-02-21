import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import events from '../../../api/events'

export default {
  [ actions.FETCH_EVENTS ] (context) {
    return new Promise((resolve, reject) => {
      events.fetch().then(response => {
        context.commit(mutations.SET_EVENTS, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
