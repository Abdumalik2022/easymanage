<template>
  <div class="container-login">
      <router-link class="btn btn-primary mb-4" to="/create-supplier"
        >Add Supplier
      </router-link>

    <input
      v-model="searchSupp"
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
            <h6 class="m-0 font-weight-bold text-primary">Suppliers List</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Photo</th>
                  <th>Phone</th>
                  <th>Shop Name</th>
                  <th>Address</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="suppliers in filterSearch" :key="suppliers.id">
                  <td>{{ suppliers.name }}</td>
                  <td><img id="img" :src="suppliers.photo" alt="img" /></td>
                  <td>{{ suppliers.phone }}</td>
                  <td>{{ suppliers.shopname }}</td>
                  <td>{{ suppliers.address }}</td>
                  <td>{{ suppliers.email }}</td>
                  <td>
                    <router-link
                      :to="{
                        name: 'edit-supplier',
                        params: { id: suppliers.id },
                      }"
                      class="btn btn-sm btn-primary"
                      >Edit
                    </router-link>
                    <a
                      class="btn btn-sm btn-danger text-light"
                      @click="deleteSupplier(suppliers.id)"
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
      suppliers: [],
      searchSupp: "",
    };
  },

  computed: {
    filterSearch() {
      return this.suppliers.filter((supplier) => {
        return supplier.name.match(this.searchSupp);
      });
    },
  },

  methods: {
    AllSupplier() {
      axios
        .get("/api/supplier")
        .then((response) => {
          this.suppliers = response.data;
        })
        .catch(() => {
           console.log("error taking data")
        });
    },
    deleteSupplier(id) {
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
            .delete("/api/supplier/" + id)
            .then(() => {
              this.suppliers = this.suppliers.filter((supplier) => {
                return supplier.id !== id;
              });
            })
            .catch(() => {
              this.$router.push("/supplier");
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
  },

  created() {
    this.AllSupplier();
  },
};
</script>

<style scoped>
img {
  height: 60px;
  width: 60px;
}
</style>