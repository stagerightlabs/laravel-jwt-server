<template>
  <div id="app" class="container mx-auto bg-white min-h-screen shadow-md flex flex-col justify-between">
    <nav class="flex items-center justify-between flex-wrap bg-purple p-6">
      <div class="flex items-center flex-no-shrink text-white mr-6">
        <span class="font-semibold text-xl tracking-tight">Laravel Vue JWT</span>
      </div>
      <div class="block lg:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-purple-lighter border-purple-light hover:text-white hover:border-white">
          <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
      </div>
      <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
          <div v-if="authenticated">
          <router-link :to="{ name: 'Dashboard' }" class="block mt-4 lg:inline-block lg:mt-0 text-purple-lighter hover:text-white mr-4">
            Dashboard
          </router-link>
          <router-link :to="{name: 'Secrets'}" class="block mt-4 lg:inline-block lg:mt-0 text-purple-lighter hover:text-white mr-4">
            Secrets
          </router-link>
          <a href="https://tailwindcss.com" class="block mt-4 lg:inline-block lg:mt-0 text-purple-lighter hover:text-white" target="blank">
            Tailwind CSS
          </a>
          </div>
        </div>
        <div v-if="!authenticated">
          <router-link :to="{ name: 'Register' }" class="inline-block text-sm px-4 py-2 leading-none rounded text-white hover:text-teal hover:bg-white mt-4 lg:mt-0">Register</router-link>
          <router-link :to="{ name: 'Login' }"  class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0">Log In</router-link>
        </div>
        <div v-else>
          <span class="text-white">{{ userEmail }}</span>
          <button class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0" @click="logout">Log Out</button>
        </div>
      </div>
    </nav>
    <div class="p-8 flex-auto">
      <router-view/>
    </div>
    <div class="p-4 bg-grey-lighter">
      <h5>auth.token</h5>
      <pre class="whitespace-pre-wrap break-words">{{ token }}</pre>
    </div>
    <flash-stack></flash-stack>
  </div>
</template>

<script>
import FlashStack from './components/FlashStack.vue'

export default {
  name: 'app',
  components: {
    'flash-stack': FlashStack
  },
  computed: {
    token() {
      return this.auth.user.token
    },
    authenticated() {
      return this.auth.authenticated()
    },
    userEmail() {
      return this.auth.user.email
    }
  },
  data() {
    return {
      auth: window.authority,
      apiUrl: process.env.API_URL,
    }
  },
  methods: {
    logout() {
      let self = this
      axios.post(this.apiUrl + '/api/logout', {}, {
        headers: authority.header()
      })
        .then(response => {
          authority.logout()
          window.flash("Your session has been terminated.", "success")
          self.$router.push({name: 'Login'})
        })
        .catch(error => {
          console.log(error)
          authority.logout()
          window.flash("Your session has been terminated.", "success")
        })
    }
  },
  created() {
    authority.check()
    window.events.$on('authorized', (jwt) => {
      authority.login(jwt)
    })

  }
}
</script>
