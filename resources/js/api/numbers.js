import axios from 'axios'

export default {
  fetch () {
    return axios.get('/api/v1/numbers')
  },
  assignNumberToUser (user, description) {
    description = description || ''
    return axios.post('/api/v1/user/' + user.id + '/assign_number', {
      'description': description
    })
  },
  unassignNumberToUser (number) {
    return axios.delete('/api/v1/number/' + number.id + '/assign')
  },
  unassignNumbersToUser (user) {
    return axios.post('/api/v1/user/' + user.id + '/unassign_numbers')
  }
}
