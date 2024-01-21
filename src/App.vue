<template>
  <component :is="resolveLayout" >
    <router-view></router-view>
  </component>
</template>

<script>
import LoginView from './views/LoginView.vue'
import RegistrationView from './views/RegistrationView.vue';

export default {
  components: {
    LoginView,
    RegistrationView
  },
  setup() {

  },
  computed: {
    resolveLayout() {
      return this.$route.name
    }
  }
}
</script>