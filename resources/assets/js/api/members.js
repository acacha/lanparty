import axios from 'axios'

export default {
  leave (group) {
    return axios.delete('/api/v1/group/' + group.id + '/member')
  }
}
