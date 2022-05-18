<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/expense"
        >All Expenses</router-link
      >

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Expense</h1>
                  </div>
                  <form
                    class="register"
                    @submit.prevent="expenseInsert"
                  >
                    <div class="form-row">

                       <div class="col-12">
                          <div class="form-group">
                             <label for="exampleFormControlTextarea1"> <b>Expense Details</b>  </label>
                             <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                             v-model="form.details"></textarea>
                             <small class="text-danger" v-if="errors.details">
                            {{ errors.details[0] }}
                          </small>
                          </div>
                       </div>

                       <div class="col-12">
                          <div class="form-group">
                             <label for="exampleFormControlTextarea2"> <b>Expense Amount</b>  </label>
                          <input
                            v-model="form.amount"
                            class="form-control"
                            placeholder="Enter Your Amount"
                            type="text"
                            id="exampleFormControlTextarea2"
                          />
                          <small class="text-danger" v-if="errors.amount">
                            {{ errors.amount[0] }}
                          </small>
                        </div>
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
        details: null,
        amount: null,
      },
      errors: {},
    };
  },
  methods: {
    expenseInsert() {
      axios
        .post("/api/expense", this.form)
        .then(() => {
          this.$router.push("/expense");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style scoped>
</style>