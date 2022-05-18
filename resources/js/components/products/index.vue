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
            <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th style="width:15%">Name</th>
                  <th style="width:8%">Code</th>
                  <th style="width:10%">Photo</th>
                  <th style="width:10%">Category</th>
                  <th style="width:14%">Buying Price</th>
                  <th style="width:14%">Selling Price</th>
                  <th style="width:10%">Root</th>
                  <th style="width:18%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="products in filterSearch" :key="products.id">           
                  <td>{{ products.product_name }}</td>
                  <td>{{ products.product_code }}</td>
                  <td><img id="img" :src="products.image" alt="img" /></td>
                  <td>{{ products.category_name }}</td>
                  <td>{{ products.buying_price }}</td>
                  <td>{{ products.selling_price }}</td>
                  <td>{{ products.root }}</td>
                  <td>
                    <router-link
                      :to="{
                        name: 'edit-product',
                        params: { id: products.id },
                      }"
                      class="btn btn-sm btn-primary"
                      >Edit
                    </router-link>
                    <a
                      class="btn btn-sm btn-danger text-light"
                      @click="deleteProduct(products.id)"
                      >Delete</a
                    >
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
    deleteProduct(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("/api/product/" + id)
            .then(() => {
              this.products = this.products.filter((product) => {
                return product.id !== id;
              });
            })
            .catch(() => {
              this.$router.push("/product");
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
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