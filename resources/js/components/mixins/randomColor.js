export default {
  methods: {
    randomColor () {
      var colors = [
        'red',
        'pink',
        'purple',
        'deep-purple',
        'indigo',
        'blue',
        'light-blue',
        'cyan',
        'green',
        'light-green',
        'lime',
        'yellow darken-2',
        'amber',
        'orange',
        'deep-orange',
        'brown',
        'blue-gray'
      ]

      return colors[Math.floor(Math.random() * colors.length)]
    }
  }
}
