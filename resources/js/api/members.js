export default {
  leave (group) {
    return window.axios.delete('/api/v1/group/' + group.id + '/member')
  }
}
