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
  },
  update (user) {
    return axios.put('/api/v1/user', {
      'name': user.name,
      'givenName': user.givenName,
      'sn1': user.sn1,
      'sn2': user.sn2,
      'email': user.email
    })
  }
}
