<template>
   <div class="container-login">
      <router-link class="btn btn-primary mb-4" to="/create-expense"
      >Add Expense
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
                  <h6 class="m-0 font-weight-bold text-primary">Expenses List</h6>
               </div>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                     <tr>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="expenses in filterSearch" :key="expenses.id">
                        <td>{{ expenses.details }}</td>
                        <td>{{ expenses.amount }}</td>
                        <td>{{ expenses.expense_date }}</td>
                        <td>
                           <router-link
                              :to="{ name: 'edit-expense', params: { id: expenses.id } }"
                              class="btn btn-sm btn-primary"
                           >Edit
                           </router-link>
                           <a
                              class="btn btn-sm btn-danger text-light"
                              @click="deleteExpense(expenses.id)"
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
         expenses: [],
         searchEmpl: "",
      };
   },
   
   computed: {
      filterSearch() {
         return this.expenses.filter((expense) => {
            return expense.expense_date.match(this.searchEmpl);
         });
      },
   },
   
   methods: {
      AllExpense() {
         axios
            .get("/api/expense")
            .then((response) => {
               this.expenses = response.data;
            })
            .catch();
      },
      deleteExpense(id) {
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
                  .delete("/api/expense/" + id)
                  .then(() => {
                     this.expenses = this.expenses.filter((expense) => {
                        return expense.id !== id;
                     });
                  })
                  .catch(() => {
                     this.$router.push("/expense");
                  });
               Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
         });
      },
   },
   
   created() {
      this.AllExpense();
   },
};
</script>

<style scoped>
img {
   height: 60px;
   width: 60px;
}
</style>