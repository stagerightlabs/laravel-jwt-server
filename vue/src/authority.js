export let authority = {
  user: {
    authenticated: false,
  },

  login(jwt) {
    localStorage.setItem('token', jwt)
    this.user.authenticated = true
  },

  logout() {
    localStorage.removeItem('token')
  },

  check() {
    var jwt = this.token()

    if (jwt) {
      this.user.authenticated = true
    } else {
      this.user.authenticated = false
    }

    return this.user.authenticated
  },

  authenticated() {
    return this.user.authenticated
  },

  token() {
    return localStorage.getItem('token') || null
  },

  header() {
    return {
      'Authorization': 'Bearer ' + this.token()
    }
  }


}