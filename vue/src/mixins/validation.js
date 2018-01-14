export default {
  data() {
    return {
      errors: {}
    }
  },
  methods: {
    hasError(key) {
      return this.errors.hasOwnProperty(key)
    },
    getErrorMessage(key) {
      if (this.errors.hasOwnProperty(key)) {
        return this.errors[key][0]
      }
    },
    clearErrors() {
      this.errors = {}
    },
  }
}