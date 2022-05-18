<template>
  <div class="container-login">
      <router-link class="btn btn-primary" to="/product"
        >All Products</router-link
      >

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                  </div>
                  <form class="register" @submit.prevent="productInsert" 
                    enctype="multipart/form-data"
                  >

                     <!-- row start -->
                    <div class="form-row">
                       <div class="col-6">
                          <div class="form-group">
                             <label for="product_name">Product Name</label>
                          <input
                            v-model="form.product_name"
                            class="form-control"
                            placeholder="Enter Your Product Name"
                            type="text"
                            id="name"
                          />
                          <small class="text-danger" v-if="errors.product_name">
                            {{ errors.product_name[0] }}
                          </small>
                        </div>
                       </div>

                       <div class="col-6">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Product Code</label>
                          <input
                            v-model="form.product_code"
                            class="form-control"
                            placeholder="Enter Your Product Code"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.product_code">
                            {{ errors.product_code[0] }}
                          </small>
                        </div>
                       </div>
                    </div>
                    <!-- row end -->


                  <!-- row start -->
                  <div class="form-row">
                     <div class="col-6">
                        <div class="form-group">
                           <label for="exampleFormControlSelect1">Product Category</label>
                           <select class="form-select" id="exampleFormControlSelect1" v-model="form.category_id">
                              <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.category_name }}
                              </option>
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group">
                           <label for="exampleFormControlSelect1">Supplier of Product</label>
                           <select class="form-select" id="exampleFormControlSelect2" v-model="form.supplier_id">
                              <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                {{ supplier.name }}
                              </option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <!-- row end -->
                    

                  <!-- row start -->
                    <div class="form-row">
                       <div class="col-4">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Product Root</label>
                          <input
                            v-model="form.root"
                            class="form-control"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.root">
                            {{ errors.root[0] }}
                          </small>
                        </div>
                       </div>

                       <div class="col-4">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Buying Price</label>
                          <input
                            v-model="form.buying_price"
                            class="form-control"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.buying_price">
                            {{ errors.buying_price[0] }}
                          </small>
                        </div>
                       </div>

                       <div class="col-4">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Selling Price</label>
                          <input
                            v-model="form.selling_price"
                            class="form-control"
                            type="text"
                          />
                          <small class="text-danger" v-if="errors.selling_price">
                            {{ errors.selling_price[0] }}
                          </small>
                        </div>
                       </div>
                    </div>
                    <!-- row end -->

                    <!-- row start -->
                    <div class="form-row">
                       <div class="col-6">
                           <div class="form-group">
                             <label for="exampleFormControlSelect1">Buying Date</label>
                                 <input
                                 v-model="form.buying_date"
                                 class="form-control"
                                 type="date"
                                 />
                                 <small class="text-danger" v-if="errors.buying_date">
                                    {{ errors.buying_date[0] }}
                                 </small>
                           </div>
                        </div>

                       <div class="col-6">
                          <div class="form-group">
                             <label for="exampleFormControlSelect1">Product Quantity</label>
                          <input
                            v-model="form.product_quantity"
                            class="form-control"
                            type="text"
                            placeholder="Enter the quantity"
                          />
                          <small class="text-danger" v-if="errors.product_quantity">
                            {{ errors.product_quantity[0] }}
                          </small>
                        </div>
                       </div>
                    </div>
                    <!-- row end -->

                    <!-- row start -->
                    <div class="form-row mt-3">
                      <div class="col-6">
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

                      <div class="col-3">
                        <img
                          :src="form.image"
                          style="height: 36px; width: 52px;"
                          alt="image"
                          />
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
        category_id: null,
        product_name: null,
        product_code: null,
        root: null,
        buying_price: null,
        selling_price: null,
        supplier_id: null,
        buying_date: null,
        image: null,
        product_quantity: null,
      },
      errors: {},
      categories: {},
      suppliers: {},
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
          this.form.image = event.target.result;
        };
        reader.readAsDataURL(image);
      }
    },
    productInsert() {
      axios
        .post("/api/product", this.form)
        .then(() => {
          this.$router.push("/product");
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
  created() {
    axios
      .get('api/category')
      .then((response) => {
        this.categories = response.data
      })

    axios
      .get('api/supplier')
      .then((response) => {
        this.suppliers = response.data
      })  
  }

};
</script>

<style scoped>
.mt-3 {
    margin-top: 0.7rem !important;
}
</style>