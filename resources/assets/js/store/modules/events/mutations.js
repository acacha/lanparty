import * as types from '../../mutation-types'

export default {
  [ types.SET_EVENTS ] (state, events) {
    state.events = events
  },
  [ types.SET_EVENT_AS_INSCRIBED ] (state, {event, user}) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) {
        newEvents[index].inscribed = true
        newEvents[index].assigned_tickets++
        newEvents[index].available_tickets--
        newEvents[index].users.push(user)
      }
    })
    state.events = newEvents
  },
  [ types.SET_GROUP_EVENT_AS_INSCRIBED ] (state, {event, group}) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) {
        newEvents[index].inscribed = true
        newEvents[index].assigned_tickets++
        newEvents[index].available_tickets--
        newEvents[index].groups.push(group)
      }
    })
    state.events = newEvents
  },
  [ types.SET_EVENT_AS_UNSUBSCRIBED ] (state, {event, user}) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) {
        newEvents[index].inscribed = false
        newEvents[index].users.splice(newEvents[index].users.indexOf(user), 1)
        newEvents[index].assigned_tickets--
        newEvents[index].available_tickets++
      }
    })
    state.events = newEvents
  },
  [ types.SET_GROUP_EVENT_AS_UNSUBSCRIBED ] (state, {event, group}) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) {
        newEvents[index].inscribed = false
        const groupIndex = newEvents[index].groups.indexOf(group)
        const userIndex = newEvents[index].groups[groupIndex].members.indexOf(user)
        newEvents[index].groups[groupIndex].members.splice(userIndex, 1)
      }
    })
    state.events = newEvents
  },
  [ types.SET_EVENT_AS_LOADING ] (state, event) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) newEvents[index].loading = true
    })
    state.events = newEvents
  },
  [ types.UNSET_EVENT_AS_LOADING ] (state, event) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) newEvents[index].loading = false
    })
    state.events = newEvents
  },
  [ types.REMOVE_GROUP_FROM_EVENT ] (state, event, group) {
    state.events.indexOf()
    let foundEvent = state.events.find((e) => {
      return e.id === event.id
    })
    foundEvent.groups.splice(foundEvent.groups.indexOf(group), 1)
    foundEvent.assigned_tickets--
    foundEvent.available_tickets++
  }
}
