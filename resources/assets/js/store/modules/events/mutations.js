import * as types from '../../mutation-types'

export default {
  [ types.SET_EVENTS ] (state, events) {
    state.events = events
  },
  [ types.SET_EVENT_AS_INSCRIBED ] (state, event) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) newEvents[index].inscribed = true
    })
    state.events = newEvents
  },
  [ types.SET_EVENT_AS_UNSCRIBED ] (state, event) {
    let newEvents = []
    state.events.forEach((item, index) => {
      newEvents[index] = item
      if (item.id === event.id) newEvents[index].inscribed = false
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
  }
}
