<template>
  <div>
    <h1>Login</h1>
    <form class="w-full max-w-sm mx-auto">
      <div class="md:flex md:items-baseline mb-6">
        <div class="md:w-1/3">
          <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
            Email
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter focus:border-purple rounded w-full py-2 px-4 text-grey-darker" id="inline-full-name" type="email" placeholder="jane@example.com" v-model="credentials.email">
          <p class="text-red text-sm mt-1" v-if="hasError('email')">{{ getErrorMessage('email') }}</p>
        </div>
      </div>
      <div class="md:flex md:items-baseline mb-6">
        <div class="md:w-1/3">
          <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-username">
            Password
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter focus:border-purple rounded w-full py-2 px-4 text-grey-darker" id="inline-username" type="password" placeholder="******************" v-model="credentials.password">
          <p class="text-red text-sm mt-1" v-if="hasError('password')">{{ getErrorMessage('password') }}</p>
        </div>
      </div>
      <div class="md:flex md:items-baseline">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
          <button
            class="shadow bg-purple hover:bg-purple-light text-white font-bold py-2 px-4 rounded"
            type="button"
            @click.prevent="login">Login
          </button>
          <button
            class="shadow bg-white border-1 border-purple hover:bg-purple-light text-black font-bold py-2 px-4 rounded"
            type="button"
            @click.prevent="forgot">Forgot Password
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import validation from '../mixins/validation'

export default {
  mixins: [validation],
  data () {
    return {
      credentials: {
        email: '',
        password: ''
      },
      apiUrl: process.env.API_URL,
    }
  },
  methods: {
    forgot() {
      this.$router.push({name: 'ForgotPassword'})
    },
    login () {
      let self = this
      this.clearErrors()
      axios.post(this.apiUrl + "/api/login", this.credentials)
        .then(response =>  {
          window.events.$emit('authorized', response.data)
          window.authority.user.email = this.credentials.email
          this.$router.push({name: 'Dashboard'})
          this.resetForm()
        })
        .catch(error => {
          if (error.response.hasOwnProperty('data')) {
            this.errors = error.response.data.errors
          }
        })
    },
    resetForm () {
      this.credentials = {
        email: '',
        password: '',
      }
      this.clearErrors()
    },
  }
}
</script>