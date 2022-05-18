<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/stock"
        >Go Back</router-link
      >

    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Stock Update</h1>
                  </div>
                  <form class="register" @submit.prevent="stockUpdate" 
                    enctype="multipart/form-data"
                  >

                    <!-- row start -->
                    <div class="form-row">
                       <div class="col-12">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Product Quantity</label>
                          <input
                            v-model="form.product_quantity"
                            class="form-control"
                            type="text"
                            placeholder="Enter the quantity"
                          />
                        </div>
                       </div>
                    </div>
                    <!-- row end -->

               

                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="submit">
                        Submit
                      </button>
                    </div>
                  </form>
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
  name: "create",
  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
  },
  data() {
    return {
      form: {
        product_quantity: '',
      },
    };
  },
  methods: {
    stockUpdate() {
      let id = this.$route.params.id
      axios
        .patch("/api/product/" + id, this.form)
        .then(() => {
          this.$router.push("/stock");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
  created() {
      let id = this.$route.params.id
      axios.get("/api/product/" + id)
      .then((response) => {
         this.form = response.data
      })
      .catch(() => {
         console.log('error')
      })
  }

};
</script>

<style scoped>
.mt-3 {
    margin-top: 0.7rem !important;
}
</style>