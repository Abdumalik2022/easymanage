<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/employee"
        >All Categories
      </router-link>

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Category Update</h1>
                  </div>
                  <form
                    class="register"
                    @submit.prevent="categoryUpdate"
                  >
                    <div class="form-row">
                     <div class="col-12">
                        <div class="form-group">
                          <input
                            v-model="form.category_name"
                            class="form-control"
                            placeholder="Enter Your Category Name"
                            type="text"
                            required
                          />
                        </div>
                     </div>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="submit">
                        Update
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
  data() {
    return {
      form: {
        category_name: "",
      }
    };
  },

  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }

    let id = this.$route.params.id;
    axios
      .get("/api/category/" + id)
      .then((response) => {
        this.form = response.data;
      })
      .catch(() => console.log("error"));
  },

  methods: {
    categoryUpdate() {
      let id = this.$route.params.id;
      axios
        .patch("/api/category/" + id, this.form)
        .then(() => {
          this.$router.push("/category");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
</style>