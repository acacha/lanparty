import * as actions from '../../action-types'
import eventsRegistration from '../../../api/events-registration'

export default {
  [ actions.REGISTER_CURRENT_USER_TO_EVENT ] (context, event) {
    console.log('PROVA!!!!!!!!!!!!!!!!!')
    return new Promise((resolve, reject) => {
      eventsRegistration.register(event).then(response => {
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
