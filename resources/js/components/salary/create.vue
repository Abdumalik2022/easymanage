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
                    <h1 class="h4 text-gray-900 mb-4">Pay Salary</h1>
                  </div>
                  <form
                    class="register"
                    @submit.prevent="paySalary"
                  >  
                    <div class="form-row">
                      <div class="col-6">
                        <div class="form-group">
                        <label for="exampleFormControlSelect1">Name</label>
                          <input
                            v-model="form.name"
                            class="form-control"
                            placeholder="Enter Your Full Name"
                            type="text"
                          />
                          <small v-if="errors.name" class="text-danger">
                            {{ errors.name[0] }}
                          </small>
                        </div>

                        <label for="exampleFormControlSelect1">Month</label>
                           <select class="form-control" id="exampleFormControlSelect1"
                           v-model="form.salary_month">
                              <option value="January">January</option>
                              <option value="February">February</option>
                              <option value="March">March</option>
                              <option value="April">April</option>
                              <option value="May">May</option>
                              <option value="June">June</option>
                              <option value="July">July</option>
                              <option value="August">August</option>
                              <option value="September">September</option>
                              <option value="October">October</option>
                              <option value="November">November</option>
                              <option value="December">December</option>
                           </select>
                           <small v-if="errors.salary_month" class="text-danger">
                            {{ errors.salary_month[0] }}
                          </small>

                      </div>
                      <div class="col-6">
                        <div class="form-group">
                        <label for="exampleFormControlSelect1">Email</label>
                          <input
                            v-model="form.email"
                            class="form-control"
                            placeholder="Enter Your Email"
                            type="email"
                          />
                          <small v-if="errors.email" class="text-danger">
                            {{ errors.email[0] }}
                          </small>
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlSelect1">Salary</label>
                          <input
                            v-model="form.salary"
                            class="form-control"
                            placeholder="Enter Your Salary"
                            type="text"
                          />
                          <small v-if="errors.salary" class="text-danger">
                            {{ errors.salary[0] }}
                          </small>
                        </div>

                        
                      </div>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="submit">
                        PayNow
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
        salary: "",
        salary_month: "",
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
    paySalary() {
      let id = this.$route.params.id;
      axios
        .post("/api/salary/paid/" + id, this.form)
        .then(() => {
          this.$router.push("/given-salary");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
</style>