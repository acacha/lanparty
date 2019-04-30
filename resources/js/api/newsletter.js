export default {
  subscribe (email) {
    return window.axios.post('/api/v1/newsletter', {'email': email})
  }
}
