import axios from 'axios'

export default {
  fetch () {
    return axios.get('/api/v1/events')
  },
  register (event) {
    return axios.post('/api/v1/events/' + event.id + '/register')
  },
  unregister (event) {
    return axios.delete('/api/v1/events/' + event.id + '/register')
  },
  unregisterUser (user, event) {
    return axios.delete('/api/v1/events/' + event.id + '/register/user/' + user.id)
  },
  registerUser (user, event) {
    return axios.post('/api/v1/events/' + event.id + '/register/user/' + user.id)
  },
  unregisterAllEvents (user) {
    return axios.delete('/api/v1/events/register/user/' + user.id)
  }
}
