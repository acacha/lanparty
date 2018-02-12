import axios from 'axios'

export default {
  login (credentials) {
    return axios.post('/login', credentials)
  },
  logout () {
    return axios.post('/logout')
  }
}
