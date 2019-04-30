export default {
  fetch () {
    return window.axios.get('/api/v1/events')
  },
  register (event) {
    return window.axios.post('/api/v1/events/' + event.id + '/register')
  },
  unregister (event) {
    return window.axios.delete('/api/v1/events/' + event.id + '/register')
  },
  unregisterUser (user, event) {
    return window.axios.delete('/api/v1/events/' + event.id + '/register/user/' + user.id)
  },
  registerUser (user, event) {
    return window.axios.post('/api/v1/events/' + event.id + '/register/user/' + user.id)
  },
  unregisterAllEvents (user) {
    return window.axios.delete('/api/v1/events/register/user/' + user.id)
  },
  registerGroupToEvent (event, group) {
    const formData = new FormData()
    formData.append('avatar', group.avatar)
    formData.append('name', group.name)
    formData.append('ids', group.user_ids)
    return window.axios.post('/api/v1/events/' + event.id + '/register_group', formData)
  },
  unregisterGroupToEvent (event, group) {
    return window.axios.delete('/api/v1/events/' + event.id + '/register_group/' + group.id)
  }
}
