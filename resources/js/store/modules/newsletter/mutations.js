import * as types from '../../mutation-types'

export default {
  [ types.NEWSLETTER_EMAIL ] (state, email) {
    state.email = email
  }
}
