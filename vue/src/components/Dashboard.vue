<template>
  <div>
    <h1>Dashboard</h1>
    <p class="w-full mt-4"><a class="bg-grey-dark hover:bg-grey-darker text-white font-bold py-2 px-4 m-2 rounded cursor-pointer" @click.prevent="alert('this is a flash message this is a flash message this is a flash message', 'danger')">Trigger Alert</a></p>
  </div>
</template>

<script>
export default {
  methods: {
    alert(message, level) {
      console.log(level);
      window.flash(message, level)
    }
  }
}
</script>
