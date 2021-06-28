<template>
  <Transition name="slide-fade">
    <div v-if="messages.length" class="" role="alert">
      <ul class="list-unstyled">
        <li v-for="(message, index) in messages" :key="index" :class="{
          'alert alert-danger': message.type === 'error',
          'alert alert-success': message.type === 'success'
        }">
          {{ message.text }}
          <button type="button" class="dismiss-message" aria-label="Close" v-on:click="removeMessage(index)">
            <span aria-hidden="true">&times;</span>
          </button>
        </li>
      </ul>
    </div>
  </Transition>
</template>

<script>
export default {
  mounted() {
    this.$root.$on('errorHappened', error => {
      this.addMessage({
          'text': error,
          'type': 'error',
      });
    });

    this.$root.$on('successHappened', status => {
      this.addMessage({
        'text': status,
        'type': 'success',
      });
    });
  },

  data() {
    return {
      messages: [],
      timers: [],
    };
  },

  created() {
    this.$attrs.messages.forEach(message => {
        this.addMessage(message);
    });
  },

  methods: {

    addMessage(message) {
      this.messages.push(message);

      let timeout = message.type === 'success' ? 2000: 10000;

      this.timers.push(setTimeout(() => {
        this.removeMessage(0)
      }, timeout));
    },

    removeMessage(index) {

      this.messages.splice(index, 1);
      this.timers.splice(index, 1);
    },
  }
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
