<template>
   <div class="container-login">
         <router-link class="btn btn-primary mb-4 ms-2" to="/salary"
         >Go Back
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
                  <h6 class="m-0 font-weight-bold text-primary">Employees Salary Details</h6>
               </div>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                     <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="salary in filterSearch" :key="salary.id">
                        <td>{{ salary.name }}</td>
                        <td>{{ salary.salary_month }}</td>
                        <td>{{ salary.amount }}</td>
                        <td>{{ salary.salary_date }}</td>
                        <td>
                           <router-link :to="{ name: 'edit-salary', params:{ id: salary.id }}"
                                class="btn btn-sm btn-primary">Edit Salary</router-link>
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
         salaries: [],
         searchEmpl: "",
      };
   },
   
   computed: {
         filterSearch() {
            return this.salaries.filter((salary) => {
               return salary.salary_date.match(this.searchEmpl);
            });
         },
      },
   
   methods: {
      AllEmployee() {
         let id = this.$route.params.id
         axios
            .get("/api/salary/view/" + id)
            .then((response) => {
               this.salaries = response.data;
            })
            .catch();
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