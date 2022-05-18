<template>
  <div class="container-login">
      

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Search Order</h1>
                  </div>
                  <form class="register" @submit.prevent="searchOrder">
                    <div class="form-row">

                       <div class="col-12">
                          <div class="form-group">
                             <label for="exampleFormControlTextarea2"> <b>Search By Date</b></label>
                           <input v-model="date" class="form-control" type="date" id="exampleFormControlTextarea2"/>
                        </div>
                       </div>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="submit">
                        Search
                      </button>
                    </div>
                  </form>



                  <div class="row mt-5" v-if="orders">
               <div class="col">
                  <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Product Name</th> 
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th>Vat</th>
                        <th>Total</th>
                        <th>Pay</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.name }}</td>
                        <td>{{ order.qty }}</td>
                        <td>{{ order.subtotal }} $</td>
                        <td>{{ order.vat }}</td>
                        <td>{{ order.total }} $</td>
                        <td>{{ order.pay }} $</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
               </div>
            </div>




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
       date: '',
       orders: '',
    };
  },
  methods: {
    searchOrder() {
      let data = { date: this.date }
      axios
        .post("/api/search/order", data)
        .then((response) => {
           this.orders = response.data
        })
        .catch();
    },
  },
};
</script>

<style scoped>
</style>