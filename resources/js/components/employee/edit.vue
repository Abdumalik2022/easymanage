<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/employee"
        >All Employee
      </router-link>

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Employee Update</h1>
                  </div>
                  <form
                    class="register"
                    enctype="multipart/form-data"
                    @submit.prevent="employeeUpdate"
                  >
                    <div class="form-row">
                      <div class="col-6">
                        <div class="form-group">
                          <input
                            v-model="form.name"
                            class="form-control"
                            placeholder="Enter Your Full Name"
                            type="text"
                          />
                          <small v-if="errors.name" class="text-danger">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.address"
                            class="form-control"
                            placeholder="Enter Your Address"
                            required
                            type="text"
                          />
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.joining_date"
                            class="form-control"
                            required
                            type="date"
                          />
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.phone"
                            class="form-control"
                            placeholder="Enter Your Phone Number"
                            type="text"
                          />
                          <small v-if="errors.name" class="text-danger">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <div class="custom-file">
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
                      <div class="col-6">
                        <div class="form-group">
                          <input
                            v-model="form.email"
                            class="form-control"
                            placeholder="Enter Your Email"
                            type="email"
                          />
                          <small v-if="errors.name" class="text-danger">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.salary"
                            class="form-control"
                            placeholder="Enter Your Salary"
                            type="text"
                          />
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.nid"
                            class="form-control"
                            placeholder="Enter Your Nid"
                            type="text"
                          />
                        </div>

                        <img
                          :src="form.newPhoto"
                          alt="image"
                          style="height: 90px; width: 115px"
                        />
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
        name: "",
        email: "",
        address: "",
        joining_date: "",
        phone: "",
        salary: "",
        nid: "",
        photo: "",
        newPhoto: "",
      },
      errors: {},
    };
  },

  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }

    let id = this.$route.params.id;
    axios
      .get("/api/employee/" + id)
      .then((response) => {
        this.form = response.data;
      })
      .catch(() => console.log("error"));
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
    employeeUpdate() {
      let id = this.$route.params.id;
      axios
        .patch("/api/employee/" + id, this.form)
        .then(() => {
          this.$router.push("/employee");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
</style>