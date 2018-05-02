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
  },
  [ actions.REGISTER_GROUP_TO_EVENT ] (context, {event, group}) {
    return new Promise((resolve, reject) => {
      context.commit(mutations.SET_EVENT_AS_LOADING, event)
      events.registerGroupToEvent(event, group).then(response => {
        const group = response.data
        context.commit(mutations.SET_GROUP_EVENT_AS_INSCRIBED, {event, group})
        resolve(response)
      }).catch(error => {
        reject(error)
      }).then(() => {
        context.commit(mutations.UNSET_EVENT_AS_LOADING, event)
      })
    })
  },
  [ actions.UNREGISTER_GROUP_TO_EVENT ] (context, {event, group}) {
    return new Promise((resolve, reject) => {
      context.commit(mutations.SET_EVENT_AS_LOADING, event)
      events.unregisterGroupToEvent(event, group).then(response => {
        context.commit(mutations.SET_GROUP_EVENT_AS_UNSUBSCRIBED, {event, group})

        resolve(response)
      }).catch(error => {
        reject(error)
      }).then(() => {
        context.commit(mutations.UNSET_EVENT_AS_LOADING, event)
      })
    })
  },
  [ actions.UNREGISTER_USER_TO_EVENT ] (context, {user, event}) {
    return new Promise((resolve, reject) => {
      events.unregisterUser(user, event).then(response => {
        context.commit(mutations.UNREGISTER_SELECTED_USER_TO_EVENT, event)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.REMOVE_USER_FROM_EVENT ] (context, {user, event}) {
    return new Promise((resolve, reject) => {
      events.unregisterUser(user, event).then(response => {
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.REGISTER_USER_TO_EVENT ] (context, {user, event}) {
    return new Promise((resolve, reject) => {
      events.registerUser(user, event).then(response => {
        context.commit(mutations.REGISTER_SELECTED_USER_TO_EVENT, event)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [ actions.UNREGISTER_ALL_EVENTS ] (context, user) {
    return new Promise((resolve, reject) => {
      events.unregisterAllEvents(user).then(response => {
        context.commit(mutations.SET_SELECTED_USER_EVENTS, [])
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
