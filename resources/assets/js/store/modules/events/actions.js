import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import events from '../../../api/events'
import members from '../../../api/members'

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
  },
  [ actions.REGISTER_CURRENT_USER_TO_EVENT ] (context, {event, user}) {
    return new Promise((resolve, reject) => {
      context.commit(mutations.SET_EVENT_AS_LOADING, event)
      events.register(event).then(response => {
        context.commit(mutations.SET_EVENT_AS_INSCRIBED, {event, user})
        resolve(response)
      }).catch(error => {
        reject(error)
      }).then(() => {
        context.commit(mutations.UNSET_EVENT_AS_LOADING, event)
      })
    })
  },
  [ actions.UNREGISTER_CURRENT_USER_TO_EVENT ] (context, {event, user}) {
    return new Promise((resolve, reject) => {
      context.commit(mutations.SET_EVENT_AS_LOADING, event)
      events.unregister(event).then(response => {
        context.commit(mutations.SET_EVENT_AS_UNSUBSCRIBED, {event, user})
        resolve(response)
      }).catch(error => {
        reject(error)
      }).then(() => {
        context.commit(mutations.UNSET_EVENT_AS_LOADING, event)
      })
    })
  },
  [ actions.UNREGISTER_CURRENT_USER_TO_GROUP_EVENT ] (context, {event, group, user}) {
    return new Promise((resolve, reject) => {
      context.commit(mutations.SET_EVENT_AS_LOADING, event)
      members.leave(group).then(response => {
        context.commit(mutations.SET_GROUP_EVENT_AS_UNSUBSCRIBED, {event, group, user})
        resolve(response)
      }).catch(error => {
        reject(error)
      }).then(() => {
        context.commit(mutations.UNSET_EVENT_AS_LOADING, event)
      })
    })
  }
}
