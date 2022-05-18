<template>
   <div class="container-login">
      <router-link class="btn btn-primary mb-4" to="/create-category"
      >Add Category
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
                  class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
               >
                  <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
               </div>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                     <tr>
                        <th>Category Name</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="categories in filterSearch" :key="categories.id">
                        <td>{{ categories.category_name }}</td>
                        <td>
                           <router-link
                              :to="{ name: 'edit-category', params: { id: categories.id } }"
                              class="btn btn-sm btn-primary"
                           >Edit
                           </router-link>
                           <a
                              class="btn btn-sm btn-danger text-light"
                              @click="deleteCategory(categories.id)"
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
         categories: [],
         searchEmpl: "",
      };
   },
   
   computed: {
      filterSearch() {
         return this.categories.filter((category) => {
            return category.category_name.match(this.searchEmpl);
         });
      },
   },
   
   methods: {
      AllEmployee() {
         axios
            .get("/api/category")
            .then((response) => {
               this.categories = response.data;
            })
            .catch();
      },
      deleteCategory(id) {
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
                  .delete("/api/category/" + id)
                  .then(() => {
                     this.categories = this.categories.filter((category) => {
                        return category.id !== id;
                     });
                  })
                  .catch(() => {
                     this.$router.push("/category");
                  });
               Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
         });
      },
   },
   
   created() {
      this.AllEmployee();
   },
};
</script>

<style scoped>
img {
   height: 60px;
   width: 60px;
}
</style>