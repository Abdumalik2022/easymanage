<template>
   <div>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li aria-current="page" class="breadcrumb-item active">Dashboard</li>
         </ol>
      </div>
      
      <div class="row mb-3">
         
         
         <!-- Area Chart -->
         <div class="col-xl-5 col-lg-4">
            <div class="card mb-4">
               
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                  <a class="m-0 float-right btn btn-primary btn-sm" href="#">Insert Customer</a>
                </div>
                <div class="table-responsive" style="font-size: 12px; ">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="p-2">
                      <tr v-for="cart in carts" :key="cart.id">
                        <td>{{ cart.pro_name }}</td>
                        <td>
                           <input type="text" :value="cart.pro_quantity" style="width:23px">
                           <button class="btn btn-success btn-sm" @click="increment(cart.id)">+</button>
                           <button v-if="cart.pro_quantity >= 2" class="btn btn-danger btn-sm" 
                           @click="decrement(cart.id)">-</button>
                           <button v-else class="btn btn-danger btn-sm" disabled>-</button>
                        </td>
                        <td> {{ cart.pro_price }} </td>
                        <td>{{ cart.sub_total }}</td>
                        <td><a class="btn btn-sm btn-info text-light" @click="deleteCart(cart.id)">X</a></td>
                      </tr>
                    </tbody> 
                  </table>
                </div>
                <div class="card-footer">
                     <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           Total Quantity: <strong>{{ qty }}</strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           Sub Total <strong>{{ subtotal }} $</strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           Vat: <strong> {{ vats.vat }} %</strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           Total: <strong> {{ subtotal*vats.vat / 100 + subtotal}} $</strong>
                        </li>
                     </ul>
                     <br>

                  <form @submit.prevent="orderdone">
                     <label>Customer Name</label>
                     <select class="form-select" v-model="customer_id">
                        <option :value="customer.id" v-for="customer in customers" :key="customer.id">
                           {{customer.name}}
                        </option>
                     </select>
<br>
                     <label>Pay</label>
                     <input type="text" class="form-control" v-model="pay" required>
<br>
                     <label>Due</label>
                     <input type="text" class="form-control" v-model="due" required>
<br>
                     <label>Pay By</label>
                     <select class="form-select" v-model="payby">
                        <option value="HandCash">Hand Cash</option>
                        <option value="Cheaque">Cheaque</option>
                        <option value="GiftCard">Gift Card</option>
                     </select>
<br>
                     <button type="submit" class="btn btn-success">Submit</button>
                  </form>
               </div>
            </div>




            </div>
         </div>
         
         <!--  -->
         
         <!-- Pie Chart -->
         <div class="col-xl-7 col-lg-8">
            <div class="card mb-4">
               <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
               </div>
               <div class="card-body">
                  
                  <!-- nav-tab start -->
                  <ul id="myTab" class="nav nav-tabs" role="tablist">
                     <li class="nav-item" role="presentation">
                        <button id="home-tab" aria-controls="home" aria-selected="true" class="nav-link active"
                                data-bs-target="#home" data-bs-toggle="tab" role="tab" type="button">Home
                        </button>
                     </li>
                     <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                        <button id="profile-tab" aria-controls="profile" aria-selected="false" class="nav-link"
                                data-bs-target="#profile" data-bs-toggle="tab" role="tab" type="button"
                                 @click="getProduct(category.id)"
                        >
                                {{ category.category_name }}
                        </button>
                     </li>
                  </ul>
                  
                  <!-- search button start -->
                  <input v-model="searchProduct" class="form-control mb-4 mt-4" placeholder="Search Product"
                         style="width: 585px" type="text"/>
                  <!-- search button end -->
                  
                  <div id="myTabContent" class="tab-content">
                     <!-- Home Tab start-->
                     <div id="home" aria-labelledby="home-tab" class="tab-pane fade show active pe-4" role="tabpanel">
                        <div class="row p-1">
                           <div v-for="product in filterSearch"
                                :key="product.id" class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3"
                           >
                           <button class="btn btn-sm" @click="AddToCart(product.id)">
                              <div class="card" style="width: 8.5rem;">
                                 <img id="img" :src="product.image" class="card-img-top">
                                 <div class="card-body">
                                    <h6 class="card-title">{{ product.product_name }}</h6>
                                    <span v-if="product.product_quantity >= 1" class="badge badge-success">
                                    Available {{ product.product_quantity }}
                                 </span>
                                    <span v-else class="badge badge-danger"> Stock Out</span>
                                 </div>
                              </div>
                           </button> 
                           </div>
                        </div>
                     </div>
                     <!-- Home Tab end-->
                     
                     <div id="profile" aria-labelledby="profile-tab" class="tab-pane fade" role="tabpanel">
                        <div class="row p-1">
                           <div v-for="getProduct in getfilterSearch"
                                :key="getProduct.id" class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3"
                           ><button class="btn btn-sm" @click="AddToCart(getProduct.id)">
                              <div class="card" style="width: 8.5rem;">
                                 <img id="img" :src="getProduct.image" class="card-img-top">
                                 <div class="card-body">
                                    <h6 class="card-title">{{ getProduct.product_name }}</h6>
                                    <span v-if="getProduct.product_quantity >= 1" class="badge badge-success">
                                    Available {{ getProduct.product_quantity }}
                                 </span>
                                    <span v-else class="badge badge-danger"> Stock Out</span>
                                 </div>
                              </div>
                           </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Nav-Tab end -->
               
               
               </div>
            </div>
         </div>
      
      </div>
      <!--Row-->
   
   
   </div>
</template>

<script>
export default {
   name: "pointofsale",
   data() {
      return {
         // v-model
         customer_id: '',
         pay: '',
         due: '',
         payby: '',

         products: [],
         categories: [],
         customers: [],
         getProducts: [],  
         carts: [],
         vats: [],
         searchProduct: "",
      };
   },
   
   computed: {
      filterSearch() {
         return this.products.filter((product) => {
            return product.product_name.match(this.searchProduct);
         });
      },
      getfilterSearch() {
         return this.getProducts.filter((getProduct) => {
            return getProduct.product_name.match(this.searchProduct);
         });
      },
      qty() {
         let sum = 0;
         for (let i = 0; i < this.carts.length; i++) {
            sum += (parseFloat(this.carts[i].pro_quantity));
         }
         return sum
      },
      subtotal() {
         let sum = 0;
         for (let i = 0; i < this.carts.length; i++) {
            sum += (parseFloat(this.carts[i].pro_quantity) * parseFloat(this.carts[i].pro_price));
         }
         return sum
      }
   },
   
   methods: {
      AllProducts() {
         axios
            .get("/api/product")
            .then((response) => {
               this.products = response.data;
            })
            .catch(() => {
               console.log("error taking data")
            });
      },
      AllCategories() {
         axios
            .get('api/category')
            .then((response) => {
               this.categories = response.data 
            })
      },
      AllCustomers() {
         axios
            .get('api/customer')
            .then((response) => {
               this.customers = response.data 
            })
      },
      
      // Cart methods start:
      AddToCart(id) { 
         axios
            .get('api/add/cart/' + id)
            .then(() => {
               Reload.$emit('AfterAdd')
               Notification.AddToCart() 
            })
      },
      getProduct(id) {
         axios
            .get('/api/getting/product/' + id)
            .then((response) => {
               this.getProducts = response.data
            })
      },
      getCart() {
         axios
            .get('api/get/cart')
            .then((response) => {this.carts = response.data})
      },
      deleteCart(id) {
         axios
            .get('api/delete/cart/' + id)
            .then(() => {
               Reload.$emit('AfterAdd')
               Notification.deleted() 
            })
      },
      increment(id) {
         axios
            .get('api/increment/cart/' + id)
            .then(() => {
               Reload.$emit('AfterAdd')
               Notification.AddToCart() 
            })
      },
      decrement(id) {
         axios
            .get('api/decrement/cart/' + id)
            .then(() => {
               Reload.$emit('AfterAdd')
               Notification.AddToCart() 
            })
      },
      // Cart methods end.

      // VAT method
      vat() {
         axios
            .get('api/vat/')
            .then((response) => {
               this.vats = response.data
            })
            
      },

      orderdone() {
         let total = this.subtotal*this.vats.vat / 100 + this.subtotal;
         let data = {
            qty: this.qty,
            subtotal: this.subtotal,
            customer_id: this.customer_id,
            pay: this.pay,
            due: this.due,
            payby: this.payby,
            vat: this.vats.vat,
            total: total
         }
         axios
            .post('api/orderdone', data)
            .then(() => {
               this.$router.push('/home')
               Notification.success()
            })
      }

   }, 
   
   created() {
      this.AllProducts();
      this.AllCategories();
      this.AllCustomers();
      this.getCart();
      this.vat();
      Reload.$on('AfterAdd', () => {
         this.getCart()
      })
   },
};
</script>

<style scoped>
img {
   height: 100px;
   width: 135px;
}

h6 {
   text-decoration: none;
   color: black;
}

.card .table td, .card .table th {
    padding-right: 1rem;
    padding-left: 0.4rem;
}
</style>