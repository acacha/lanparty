import axios from 'axios'

export default {
  subscribe (email) {
    return axios.post('/api/v1/newsletter', {'email': email})
  }
}
