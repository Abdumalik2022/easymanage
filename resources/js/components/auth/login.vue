<template>
   <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
         <div class="card shadow-sm my-5">
            <div class="card-body p-0">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="login-form">
                        <div class="text-center">
                           <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                        <form class="user" @submit.prevent="login">
                           <div class="form-group">
                              <input
                                 v-model="form.email"
                                 aria-describedby="emailHelp"
                                 class="form-control"
                                 placeholder="Enter Email Address"
                                 type="email"
                                 required
                              />
                           </div>
                           <div class="form-group">
                              <input
                                 v-model="form.password"
                                 class="form-control"
                                 placeholder="Password"
                                 type="password"
                                 required
                              />
                           </div>
                           <div class="form-group">
                              <div
                                 class="custom-control custom-checkbox small"
                                 style="line-height: 1.5rem"
                              >
                                 <input
                                    id="customCheck"
                                    class="custom-control-input"
                                    type="checkbox"
                                 />
                                 <label class="custom-control-label" for="customCheck"
                                 >Remember Me</label
                                 >
                              </div>
                           </div>
                           <div class="form-group">
                              <button class="btn btn-primary btn-block" type="submit">Login</button>
                           </div>
                        </form>
                        <div class="text-center">
                           <router-link class="font-weight-bold small" to="/register">Create an Account!</router-link>
                        </div>
                        <div class="text-center">
                           <router-link class="font-weight-bold small" to="/forget">Forget Your Password?</router-link>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
export default {
   name: "login",
   created() {
      if (User.loggedIn()) {
         this.$router.push('/home')
      }
   },
   data() {
      return {
         form: {
            email: null,
            password: null
         }
      }
   },
   methods: {
      login() {
         axios.post('/api/auth/login', this.form)
            .then(res => {
               User.responseAfterLogin(res)
               Toast.fire({
                  icon: 'success',
                  title: 'Signed in successfully'
               })
               this.$router.push('/home')
            })
            .catch(() => {
               Toast.fire({
                  icon: 'warning',
                  title: 'Email or Password is Invalid'
               })
            })
      }
   }
};
</script>

<style scoped>
</style>