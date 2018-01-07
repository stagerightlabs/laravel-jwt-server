export let authority = {
  user: {
    authenticated: false,
    email: ''
  },

  login(jwt) {
    localStorage.setItem('auth_token', jwt)
    this.user.authenticated = true
  },

  logout() {
    localStorage.removeItem('auth_token')
    this.user.authenticated = false
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
    return localStorage.getItem('auth_token');
  },

  email() {
    return this.user.email
  },

  header() {
    return {
      'Authorization': 'Bearer ' + this.token()
    }
  }


}