import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import newsletter from '../../../api/newsletter'

export default {
  [ actions.SUBSCRIBE_TO_NEWSLETTER ] (context, email) {
    return new Promise((resolve, reject) => {
      newsletter.subscribe(email).then(response => {
        context.commit(mutations.NEWSLETTER_EMAIL, email)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
