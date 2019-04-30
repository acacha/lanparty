export default {
  fetch () {
    return window.axios.get('/api/v1/users')
  },
  pay ({user, session}) {
    return window.axios.post('/api/v1/user/' + user.id + '/pay',{
      'session': session
    })
  },
  unpay ({user, session}) {
    return window.axios.post('/api/v1/user/' + user.id + '/unpay', {
      'session': session
    })
  },
  update (user) {
    return window.axios.put('/api/v1/user', {
      'name': user.name,
      'givenName': user.givenName,
      'sn1': user.sn1,
      'sn2': user.sn2,
      'email': user.email
    })
  }
}
