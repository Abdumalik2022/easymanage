<template>
   <div class="container-login">
         <router-link class="btn btn-primary mb-4 ms-2" to="/create-employee"
         >Add Employee
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
                  <h6 class="m-0 font-weight-bold text-primary">Employees List</h6>
               </div>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                     <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Joining_date</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td><img id="img" :src="employee.photo" alt="img"/></td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.salary }}</td>
                        <td>{{ employee.joining_date }}</td>
                        <td>
                           <router-link
                              :to="{
                        name: 'edit-employee',
                        params: { id: employee.id },
                      }"
                              class="btn btn-sm btn-primary"
                           >Edit
                           </router-link>
                           <a
                              class="btn btn-sm btn-danger text-light"
                              @click="deleteEmployee(employee.id)"
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
         employees: [],
         searchEmpl: "",
      };
   },
   
   computed: {
      filterSearch() {
         return this.employees.filter((employee) => {
            return employee.name.match(this.searchEmpl);
         });
      },
   },
   
   methods: {
      AllEmployee() {
         axios
            .get("/api/employee")
            .then((response) => {
               this.employees = response.data;
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
                  .delete("/api/employee/" + id)
                  .then(() => {
                     this.employees = this.employees.filter((employee) => {
                        return employee.id !== id;
                     });
                  })
                  .catch(() => {
                     this.$router.push("/employee");
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