<template>
   <div class="container-login">
      <div class="row justify-content-center">
         <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card shadow-sm my-5">
               <div class="card-body p-0">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="login-form">
                           <div class="text-center">
                              <h1 class="h4 text-gray-900 mb-4">Register</h1>
                           </div>
                           <form class="register" @submit.prevent="signup">
                              <div class="form-group">
                                 <input
                                    id="exampleInputFirstName"
                                    class="form-control"
                                    placeholder="Enter Your Full Name"
                                    type="text"
                                    v-model="form.name"
                                 />
                              </div>
                              <div class="form-group">
                                 <input
                                    id="exampleInputEmail"
                                    aria-describedby="emailHelp"
                                    class="form-control"
                                    placeholder="Enter Email Address"
                                    type="email"
                                    v-model="form.email"
                                 />
                              </div>
                              <div class="form-group">
                                 <input
                                    id="exampleInputPassword"
                                    class="form-control"
                                    placeholder="Password"
                                    type="password"
                                    v-model="form.password"
                                 />
                              </div>
                              <div class="form-group">
                                 <input
                                    id="exampleInputPasswordRepeat"
                                    class="form-control"
                                    placeholder="Confirm Password"
                                    type="password"
                                    v-model="form.password_confirmation"
                                 />
                              </div>
                              <div class="form-group">
                                 <button class="btn btn-primary btn-block" type="submit">
                                    Register
                                 </button>
                              </div>
                           </form>
                           <div class="text-center">
                              <router-link class="font-weight-bold small" to="/"
                              >Already have an account?
                              </router-link
                              >
                           </div>
                           <div class="text-center"></div>
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
   name: "register",
   created() {
      // agar foydalanuvchi ro'yhatdan o'tkan bo'lsa, register
      // sahifasini ochmasdan, "srazu" /home safisiga o'tilsin.
      if (User.loggedIn()) {
         this.$router.push('/home')
      }
   },
   data() {
      return {
         form: {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
         }
      }
   },
   methods: {
      signup() {
         axios.post('/api/auth/signup', this.form)
            .then(res => {
               User.responseAfterLogin(res)
               Toast.fire({
                  icon: 'success',
                  title: 'Signed in successfully'
               })
               this.$router.push('/')
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