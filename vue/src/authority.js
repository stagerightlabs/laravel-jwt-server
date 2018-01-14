var jwtDecode = require('jwt-decode');

export let authority = {
  user: {
    authenticated: false,
    email: '',
    token: '',
  },

  jwt: {

  },

  login(jwt) {
    console.log(jwt)
    localStorage.setItem('auth_token', jwt.access_token)
    localStorage.setItem('auth_email', jwt.auth_email)
    this.user.authenticated = true
    this.user.token = jwt.access_token
    this.user.email = jwt.auth_email
    this.jwt = jwtDecode(jwt.access_token)
  },

  logout() {
    localStorage.removeItem('auth_token')
    localStorage.removeItem('auth_email')
    this.user.authenticated = false
    this.user.token = ''
    this.user.email = ''
    this.jwt = {}
  },

  check() {
    var jwt = this.token()

    if (jwt) {
      this.user.authenticated = true
      this.user.token = jwt
      this.user.email = localStorage.getItem('auth_email')
      this.jwt = jwtDecode(jwt)
    } else {
      this.user.authenticated = false
      this.user.token = ''
      this.user.email = ''
      this.jwt = {}
    }

    return this.user.authenticated
  },

  expired() {

    if (! this.jwt.hasOwnProperty('exp')) {
      return true
    }

    if (this.jwt.exp < this.epoch()) {
      return true
    }

    return false
  },

  authenticated() {
    return this.user.authenticated && ! this.expired()
  },

  token() {
    return localStorage.getItem('auth_token');
  },

  header() {
    return {
      'Authorization': 'Bearer ' + this.token()
    }
  },

  epoch() {
    return Date.now() / 1000 | 0
  }

}