<template>
  <div>
    <h1>Reset Password</h1>
    <form class="w-full max-w-sm mx-auto">
      <div class="md:flex md:items-baseline mb-6">
        <div class="md:w-1/3">
          <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
            Email
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter focus:border-purple rounded w-full py-2 px-4 text-grey-darker" id="inline-full-name" type="email" placeholder="jane@example.com" v-model="email">
          <p class="text-red text-sm mt-1" v-if="hasError('email')">{{ getErrorMessage('email') }}</p>
        </div>
      </div>
      <div class="md:flex md:items-baseline mb-6">
        <div class="md:w-1/3">
          <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
            Password
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter focus:border-purple rounded w-full py-2 px-4 text-grey-darker" id="inline-full-name" type="password" v-model="password">
          <p class="text-red text-sm mt-1" v-if="hasError('password')">{{ getErrorMessage('password') }}</p>
        </div>
      </div>
      <div class="md:flex md:items-baseline mb-6">
        <div class="md:w-1/3">
          <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
            Confirmation
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter focus:border-purple rounded w-full py-2 px-4 text-grey-darker" id="inline-full-name" type="password" v-model="password_confirmation">
          <p class="text-red text-sm mt-1" v-if="hasError('password_confirmation')">{{ getErrorMessage('password_confirmation') }}</p>
        </div>
      </div>
      <div class="md:flex md:items-baseline">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
          <button
            class="shadow bg-purple hover:bg-purple-light text-white font-bold py-2 px-4 rounded"
            type="button"
            @click.prevent="attemptPasswordChange">Reset Password
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
  props: ['code'],
  data() {
    return {
      email: '',
      password: '',
      password_confirmation: '',
      apiUrl: process.env.API_URL,
    }
  },
  methods: {
    attemptPasswordChange() {
      let self = this
      axios.post(this.apiUrl + '/api/password/reset', {
        email: self.email,
        token: self.code,
        password: self.password,
        password_confirmation: self.password_confirmation
      })
      .then(function(response) {
        self.$router.push({name: 'Login'})
        if (response.data.hasOwnProperty('message')) {
          window.flash(response.data.message, "success")
        }
      })
      .catch(function(error) {
        console.log(error)
        if (error.response.hasOwnProperty('data')) {
          self.errors = error.response.data.errors
        }
        if (error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          window.flash(error.response.data.message, "danger")
        }
      })
    }
  }
}
</script>
