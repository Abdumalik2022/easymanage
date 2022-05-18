
<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/customer"
        >Go Back</router-link
      >

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><b><i>Updating Customer</i> </b> </h1>
                  </div>
                  <form
                    class="register"
                    @submit.prevent="customerUpdate"
                    enctype="multipart/form-data"
                  >
                    <div class="form-row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="name"><b>Name</b> </label>
                          <input
                            v-model="form.name"
                            class="form-control"
                            placeholder="Enter Your Full Name"
                            type="text"
                            id="name"
                          />
                          <small class="text-danger" v-if="errors.name">
                            {{ errors.name[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <label for="join_date"><b>Address</b>  </label>
                          <input
                            v-model="form.address"
                            class="form-control"
                            placeholder="Enter Your Address"
                            type="text"
                            id="address"
                          />
                          <small class="text-danger" v-if="errors.address">
                            {{ errors.address[0] }}
                          </small>
                        </div>


                        <div class="form-group mt-4">
                          <div class="custom-file">
                            <label for="customFile"> Image </label>
                            <input
                              id="customFile"
                              class="custom-file-input"
                              type="file"
                              @change="onFileSelected"
                            />
                            <label class="custom-file-label" for="customFile"
                              >Choose file</label
                            >
                          </div>
                        </div>
                      </div>

                      <!-- COL-6 -->
                      <div class="col-6">
                        <div class="form-group">
                          <label for="customFile"><b>Email</b></label>
                          <input
                            v-model="form.email"
                            class="form-control"
                            placeholder="Enter Your Email"
                            type="email"
                            id="email"
                          />
                          <small class="text-danger" v-if="errors.email">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <label for="number"><b>Phone</b></label>
                          <input
                            v-model="form.phone"
                            class="form-control"
                            placeholder="Enter Your Phone Number"
                            type="text"
                            id="phone"
                          />
                          <small class="text-danger" v-if="errors.phone">
                            {{ errors.phone[0] }}
                          </small>
                        </div>

                        <img
                          :src="form.newPhoto"
                          style="height: 40px; width: 50px"
                          alt="image"
                          class="mt-3"
                        />

                        <input type="hidden" v-model="form.newPhoto">
                      </div>
                    </div>

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

    let id = this.$route.params.id
    axios
      .get('/api/customer/' + id)
      .then((response) => {
        this.form = response.data
      })
      .catch(console.log('error'))

  },
  data() {
    return {
      form: {
        name: '',
        email: '',  
        address: '',
        phone: '',
        photo: '',
        newPhoto: ''
      },
      errors: {},
    };
  },
  methods: {
    onFileSelected(event) {
      let image = event.target.files[0];
      if (image.size > 1048770) {
        Notification.image_validation();
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.newPhoto = event.target.result;
        };
        reader.readAsDataURL(image);
      }
    },
    customerUpdate() {
      let id = this.$route.params.id
      axios
        .patch("/api/customer/" + id, this.form)
        .then(() => {
          this.$router.push("/customer");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
.mt-3 {
    margin-top: 0.5rem !important;
}
</style>