<template>
  <div>
    <h1>Dashboard</h1>
    <p class="w-full mt-4"><a class="bg-grey-dark hover:bg-grey-darker text-white font-bold py-2 px-4 m-2 rounded cursor-pointer" @click.prevent="alert('lorem nd prints it out. Each time you refresh  the  page,  the  number  picks  up where it left off. If you open this script on  two  different  computers', 'success')">Trigger Alert</a></p>
  </div>
</template>

<script>
export default {
  methods: {
    alert(message, level) {
      window.flash(message, level)
    }
  }
}
</script>
