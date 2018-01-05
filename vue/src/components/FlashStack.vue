<template>
  <div id="alert-stack" class="fixed flex flex-col justify-end w-100 sm:w-64">
    <transition-group name="stack">
    <flash-message
      v-for="alert in alerts"
      :message="alert.message"
      :level="alert.level"
      :nonce="alert.nonce"
      :key="alert.nonce"
      :delay=6000
      v-on:remove="remove"
    ></flash-message>
    </transition-group>
  </div>
</template>

<script>
import FlashMessage from './FlashMessage.vue'

export default {
  components: {
    'flash-message': FlashMessage
  },
  data: function() {
    return {
      alerts: []
    }
  },
  methods: {
    flash: function(message, level) {
      this.alerts.push({
        message: message,
        level: level,
        show: true,
        nonce: this.generateNonce()
      });
    },
    remove: function(nonce) {
      var index = this.alerts.findIndex(alert => alert.nonce === nonce);

      if (index !== -1) {
        this.alerts.splice(index, 1)
      }
    },
    generateNonce: function() {
      var text = "";
      var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
      for(var i = 0; i < 6; i++) {
          text += possible.charAt(Math.floor(Math.random() * possible.length));
      }
      return text;
    }
  },
  created() {
    window.events.$on('flash', (message, level) => {
      this.flash(message, level)
    })
  }
}
</script>


<style lang="css" rel="stylesheet/css">
#alert-stack {
  right: 1rem;
  bottom: 1rem;
}
.stack-enter-active, .stack-leave-active {
  transition: all 1s;
}
.stack-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
