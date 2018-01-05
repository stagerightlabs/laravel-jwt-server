<template>
  <div class="text-sm p-2 mt-2 relative hidden border-2 sm:block sm:rounded sm:text-base sm:p-4 sm:pr-6 sm:mt-4" :class="styling" role="alert" v-show="show">
    <div class="dismiss" @click="dismiss"></div>
    {{ body }}
  </div>
</template>

<script>
export default {
  props: ['message', 'level', 'nonce', 'delay'],
  data: function() {
    return {
      body: '',
      type: 'info',
      show: true,
    }
  },
  computed: {
    styling() {
      if (this.level === 'success') {
        return {
          'bg-green-lightest': true,
          'text-green-dark': true,
          'border-green-light': true
        }
      }

      if (this.level === 'info') {
        return {
          'bg-blue-lightest': true,
          'text-blue-dark': true,
          'border-blue-light': true
        }
      }

      if (this.level === 'warning') {
        return {
          'bg-yellow-lightest': true,
          'text-yellow-dark': true,
          'border-yellow-light': true
        }
      }

      if (this.level === 'danger') {
        return {
          'bg-red-lightest': true,
          'text-red-dark': true,
          'border-red-light': true
        }
      }

      return {}
    }
  },
  methods: {
    dismiss() {
      this.show = false
      this.$emit('remove', this.nonce)
    }
  },
  created() {
    this.body = this.message

    if (this.delay > 0) {
      setTimeout(() => {
        this.dismiss()
      }, this.delay)
    }
  }
}
</script>


<style lang="css" rel="stylesheet/css">
.alert:last-child {
  display: block !important;
}
.dismiss {
  float: right;
  width: 1rem;
  height: 1rem;
  cursor: pointer;
  position: absolute;
  top:9px;
  right: 0.5rem;
  font-size: 1rem;
}

.dismiss::before {
  content: "X";
}
</style>
