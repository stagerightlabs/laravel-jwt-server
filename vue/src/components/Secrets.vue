<template>
  <div>
    <h1>Top Secret Code Words</h1>
    <ul class="mx-auto mt-8 w-32 text-2xl">
      <li v-for="(word, index) in codewords" :key="index">{{ word }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      auth: window.authority,
      apiUrl: process.env.API_URL,
      codewords: []
    }
  },
  methods: {
    fetchCodeWords() {
      let self = this
      axios.get(this.apiUrl + '/api/secrets', {
        headers: this.auth.header()
      })
      .then(function(response) {
        self.codewords = response.data.codewords
      })
      .catch(function(error) {
        console.log(error)
        // if (error.response.data.hasOwnProperty('message')) {
        //   window.flash(error.response.data.message, 'danger')
        // }
      })
    }
  },
  created() {
    this.fetchCodeWords()
  }
}
</script>
