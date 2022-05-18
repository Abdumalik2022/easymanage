<template>

</template>

<script>
export default {
   name: "logout",
   created() {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      Toast.fire({
         icon: 'success',
         title: 'Successfully Logout'
      })
      this.$router.push( '/')
   }
}
</script>

<style scoped>

</style>