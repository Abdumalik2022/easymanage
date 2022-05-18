<template>
   <div class="container-login">
      <div class="row">
         <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
         

            <!-- ROW-1 -->
            <div class="row">
               <div class="col-6">
                  <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                </div>
                <div class="table-responsive">
                  
                  <ul class="list-group">
                     <li class="list-group-item"><b>Name : </b> {{ details.name }} </li>
                     <li class="list-group-item"><b>Phone : </b> {{ details.phone }} </li>
                     <li class="list-group-item"><b>Address : </b> {{ details.address }} </li>
                     <li class="list-group-item"><b>Date : </b> {{ details.order_date }} </li>
                     <li class="list-group-item"><b>Pay Through : </b> {{ details.payby }} </li>
                  </ul>

                </div>
              </div>
               </div>

               <!-- COL-6 -->
               <div class="col-6">
                  <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                </div>
                <div class="table-responsive">
                  
                   <ul class="list-group">
                     <li class="list-group-item"><b>Sub Total : </b> {{ details.subtotal }} $ </li>
                     <li class="list-group-item"><b>Vat : </b> {{ details.vat }} %</li>
                     <li class="list-group-item"><b>Total : </b> {{ details.total }} $</li>
                     <li class="list-group-item"><b>Pay Amount: </b> {{ details.pay }} $</li>
                     <li class="list-group-item"><b>Due Amount : </b> {{ details.due }} $</li>
                  </ul>

                </div>
              </div>
               </div> 
            </div>



            <!-- ROW-2 -->
            <div class="row mt-3">
               <div class="col">
                  <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Product Name</th> 
                        <th>Product Code</th>
                        <th>Image</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.product_name }}</td>
                        <td>{{ order.product_code }}</td>
                        <td><img :src="'/'+ order.image" ></td>
                        <td>{{ order.pro_quantity }}</td>
                        <td>{{ order.product_price }} $</td>
                        <td>{{ order.sub_total }} $</td>
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
</template>

<script>
export default {
   name: "index",
   data() {
      return {
         orders: [],
         details: [],
      };
   },
   
   
   
   methods: {
      Orders() {
         let id = this.$route.params.id
         axios
            .get('/api/order/view/' + id)
            .then((response) => {
               this.details = response.data;
            })
            .catch();
      },
      Details() {
         let id = this.$route.params.id
         axios
            .get('/api/order/view/all/' + id)
            .then((response) => {
               this.orders = response.data;
            })
            .catch();
      },
      
   },
   
   created() {
      this.Orders();
      this.Details();
   },
};
</script>

<style scoped>
img {
   height: 35px;
   width: 45=px;
}
</style>