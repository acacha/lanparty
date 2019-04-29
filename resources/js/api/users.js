import axios from 'axios'

export default {
  fetch () {
    return axios.get('/api/v1/users')
  },
  pay ({user, session}) {
    console.log('pay session:')
    console.log(session)
    return axios.post('/api/v1/user/' + user.id + '/pay',{
      'session': session
    })
  },
  unpay ({user, session}) {
    return axios.delete('/api/v1/user/' + user.id + '/pay', {
      'session': session
    })
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
