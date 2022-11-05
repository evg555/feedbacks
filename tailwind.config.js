/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/src/templates/*.php",
    "./app/public/js/*.js"
  ],
  theme: {
    screens: {
      'lg': {'max': '992px'},
      'md': {'max': '768px'},
      'sm': {'max': '480px'}
    },
    container: {
      padding: '50px',
      center: true
    },
    extend: {
      colors: {
        lightblue: '#0069D9',
        darkblue: '#0056B3',
        lightgrey: '#F2F2F2'
      }
    }
  },
  plugins: []
}
