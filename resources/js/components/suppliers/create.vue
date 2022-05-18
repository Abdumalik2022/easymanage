<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/supplier"
        >All Suppliers</router-link
      >

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Supplier</h1>
                  </div>
                  <form
                    class="register"
                    @submit.prevent="employeeInsert"
                    enctype="multipart/form-data"
                  >
                    <div class="form-row">

                       <!-- col-6 -->
                      <div class="col-6">
                        <div class="form-group">
                          <input
                            v-model="form.name"
                            class="form-control"
                            placeholder="Enter Your Full Name"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.name">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <input v-model="form.address" class="form-control" placeholder="Enter Your Address" type="text" required/>
                        </div>


                        <div class="form-group">
                          <input v-model="form.phone" class="form-control" placeholder="Enter Your Phone Number" type="text"/>
                          <small class="text-danger" v-if="errors.name">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <div class="custom-file">
                            <input id="customFile" class="custom-file-input" type="file" @change="onFileSelected"/>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                          </div>
                        </div>
                      </div>

                      <!-- COL-6 -->
                      <div class="col-6">
                        <div class="form-group">
                          <input
                            v-model="form.email"
                            class="form-control"
                            placeholder="Enter Your Email"
                            type="email"
                          />
                          <small class="text-danger" v-if="errors.name">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                          <input
                            v-model="form.shopName"
                            class="form-control"
                            placeholder="Enter Your Shop Name"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.name">
                            {{ errors.email[0] }}
                          </small>
                        </div>



                        <img
                          :src="form.photo"
                          style="height: 90px; width: 115px"
                          alt="image"
                        />
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
  },
  data() {
    return {
      form: {
        name: null,
        email: null,  
        address: null,
        shopName: null,
        phone: null,
        photo: null,
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
          this.form.photo = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(image);
      }
    },
    employeeInsert() {
      axios
        .post("/api/supplier", this.form)
        .then(() => {
          this.$router.push("/supplier");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
</style>