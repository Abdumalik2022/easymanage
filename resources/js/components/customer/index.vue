<template>
   <div class="container-login">
         <router-link class="btn btn-primary mb-4 ms-2" to="/create-customer"
         >Add Customer
         </router-link>
      
      <input
         v-model="searchEmpl"
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
                  class="card-header py-3 d-flex flex-row 
                  align-items-center justify-content-between"
               >
                  <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
               </div>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                     <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="customer in filterSearch" :key="customer.id">
                        <td>{{ customer.name }}</td>
                        <td><img id="img" :src="customer.photo" alt="img"/></td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.address }}</td>
                        <td>
                           <router-link :to="{ name: 'edit-customer', params: { id: customer.id }, }"
                              class="btn btn-sm btn-primary">Edit
                           </router-link>
                           <a class="btn btn-sm btn-danger text-light" @click="deleteEmployee(customer.id)">Delete</a>
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
         customers: [],
         searchEmpl: "",
      };
   },
   
   computed: {
      filterSearch() {
         return this.customers.filter((customer) => {
            return customer.name.match(this.searchEmpl);
         });
      },
   },
   
   methods: {
      AllCustomers() {
         axios
            .get("/api/customer")
            .then((response) => {
               this.customers = response.data;
            })
            .catch();
      },
      deleteEmployee(id) {
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
                  .delete("/api/customer/" + id)
                  .then(() => {
                     this.customers = this.customers.filter((customer) => {
                        return customer.id !== id;
                     });
                  })
                  .catch(() => {
                     this.$router.push("/customer");
                  });
               Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
         });
      },
   },
   
   created() {
      this.AllCustomers();
   },
};
</script>

<style scoped>
img {
   height: 60px;
   width: 60px;
}
</style>