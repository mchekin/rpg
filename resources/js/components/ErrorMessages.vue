<template>
  <div id="errors-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="list-unstyled">
      <li v-for="error in errors" class="">
        {{ error }}
      </li>
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</template>

<script>
export default {
  mounted() {

  },

  data() {
    return {
      errors: [
      ]
    };
  },

  created() {
    this.errors = this.$attrs.errors;
  },
}
</script>
