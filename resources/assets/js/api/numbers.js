import axios from 'axios'

export default {
  assignNumberToUser (user) {
    return axios.post('/api/v1/user/' + user.id + '/assign_number')
  }
}
