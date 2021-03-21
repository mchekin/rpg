<template>
  <Transition name="slide-fade">
    <div v-if="errors.length" id="errors-alert" class="alert alert-danger alert-dismissible" role="alert">
      <ul class="list-unstyled">
        <li v-for="error in errors" class="">
          {{ error }}
        </li>
      </ul>
      <button type="button" class="close" aria-label="Close" v-on:click="errors = []">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </Transition>
</template>

<script>
export default {
  mounted() {
    let timer;
    this.$root.$on('errorHappened', error => {
      clearTimeout(timer);

      this.errors.push(error);

      timer = setTimeout(() => {
        this.errors = [];
      }, 10000);
    });
  },

  data() {
    return {
      errors: []
    };
  },

  created() {
    this.errors = this.$attrs.errors;
  },

  methods: {}
}
</script>
<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.4s;
}

.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(400px);
  opacity: 0;
}
</style>
