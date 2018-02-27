import axios from 'axios'

export default {
  fetch () {
    return axios.get('/api/v1/users')
  },
  pay (user) {
    return axios.post('/api/v1/user/' + user.id + '/pay')
  },
  unpay (user) {
    return axios.delete('/api/v1/user/' + user.id + '/pay')
  }
}
