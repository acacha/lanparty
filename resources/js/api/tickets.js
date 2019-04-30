export default {
  fetch () {
    return window.axios.get('/api/v1/tickets')
  }
}
