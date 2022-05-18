<template>
  <div class="container-login">
      <router-link class="btn btn-primary mb-4" to="/create-product"
        >Add Product
      </router-link>

    <input
      v-model="searchProduct"
      class="form-control mb-4"
      placeholder="Search here"
      style="width: 300px"
      type="text"
    />

    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">Stock</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Photo</th>
                  <th>Category</th>
                  <th>Buying Price</th>
                  <th>Status</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="products in filterSearch" :key="products.id">           
                  <td>{{ products.product_name }}</td>
                  <td>{{ products.product_code }}</td>
                  <td><img id="img" :src="products.image" alt="img" /></td>
                  <td>{{ products.category_name }}</td>
                  <td>{{ products.buying_price }}</td>




                  <td v-if="products.product_quantity >= 1"><span class="badge badge-success">
                     Available</span>
                  </td>
                  <td v-else><span class="badge badge-danger">Stock Out</span></td>




                  <td>{{ products.product_quantity }}</td>
                  <td>
                    <router-link
                      :to="{ name: 'edit-stock', params: { id: products.id }, }" 
                        class="btn btn-sm btn-primary" >Edit
                        </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer"></div>
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
      products: [],
      searchProduct: "",
    };
  },

  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchProduct);
      });
    },
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
  },

  created() {
    this.AllProducts();
  },
};
</script>

<style scoped>
img {
  height: 60px;
  width: 60px;
}
</style>