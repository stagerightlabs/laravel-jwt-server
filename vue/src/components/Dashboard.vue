<template>
  <div>
    <h1>Dashboard</h1>
    <p class="text-center">Hello, {{ email }}.</p>
    <p class="text-center">You are logged in.</p>
    <p class="w-full text-center my-8"><a class="bg-grey-dark hover:bg-grey-darker text-white font-bold py-2 px-4 m-2 rounded cursor-pointer" @click.prevent="alert('lorem nd prints it out. Each time you refresh  the  page,  the  number  picks  up where it left off. If you open this script on  two  different  computers', 'success')">Test Alert</a></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: window.authority
    }
  },
  computed: {
    email() {
      return window.authority.user.email
    }
  },
  methods: {
    alert(message, level) {
      window.flash(message, level)
    }
  }
}
</script>
