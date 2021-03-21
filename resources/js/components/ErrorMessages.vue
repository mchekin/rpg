<template>
  <Transition name="slide-fade">
    <div v-if="errors.length" class="alert alert-danger" role="alert">
      <ul class="list-unstyled">
        <li v-for="error in errors" class="">
          {{ error }}
        </li>
      </ul>
      <button type="button" class="dismiss-message" aria-label="Close" v-on:click="errors = []">
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
.dismiss-message {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
  padding: 0.75rem 1.25rem;
  color: inherit;
  background-color: transparent;
  border: 0;
  float: right;
  font-size: 1.35rem;
  font-weight: 700;
  line-height: 1;
  text-shadow: 0 1px 0 #fff;
  opacity: 0.5;
}
</style>
