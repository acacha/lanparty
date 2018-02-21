import axios from 'axios'

export default {
  fetch () {
    return axios.get('/api/v1/events')
  }
}
