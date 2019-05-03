export default {
  fetch () {
    return window.axios.get('/api/v1/numbers')
  },
  assignNumberToUser (user, description, session) {
    description = description || ''
    return window.axios.post('/api/v1/user/' + user.id + '/assign_number', {
      'description': description,
      'session': session,
    })
  },
  unassignNumberToUser (number) {
    return window.axios.delete('/api/v1/number/' + number.id + '/assign')
  },
  unassignNumbersToUser (user) {
    return window.axios.post('/api/v1/user/' + user.id + '/unassign_numbers')
  }
}
