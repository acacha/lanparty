import axios from 'axios'

export default {
  register (event) {
    return axios.post('/api/v1/events/' + event.id + '/register')
  }
}
