<template>
  <q-page class="row items-center bg-custom justify-center">
      <loginForm/>
  </q-page>
</template>
<script>
import loginForm from 'components/loginForm.vue'
export default {
  name: 'loginPage',
  components: {
    loginForm
  }
}
</script>
