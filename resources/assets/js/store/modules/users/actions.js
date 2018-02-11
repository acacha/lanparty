import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'

export default {
  [ actions.SELECTED_USER ] (context, user) {
    context.commit(mutations.SELECTED_USER, user)
  }
}
