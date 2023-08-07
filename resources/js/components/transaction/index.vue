<template>
    <div class="container">
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Transaction</h5>
                    <router-link to="/create-transaction" class="btn btn-primary">Add</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Date</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">COA Code</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">COA Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Desc</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Debit</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Credit</h6>
                        </th>
                        <th class="border-bottom-0">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in transaction" :key="item.id">
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ item.date }}</h6></td>
                        <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">{{ item.coa.code }}</h6>
                        </td>
                        <td class="border-bottom-0">
                            {{ item.coa.name }}
                        </td>
                        <td class="border-bottom-0">
                            {{ item.desc }}
                        </td>
                        <td class="border-bottom-0">
                            {{ item.debit }}
                        </td>
                        <td class="border-bottom-0">
                            {{ item.credit }}
                        </td>
                        <td class="border-bottom-0">
                            <router-link :to="{ name: 'edit-transaction', params: { id: item.id } }" class="btn btn-sm btn-warning mx-2">Edit</router-link>
                            <button @click="deleteTransaction(item.id)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                      </tr>                  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      transaction: [],
    };
  },
  created() {
    this.fetchTransaction();
  },
  methods: {
    fetchTransaction() {
      axios
        .get("/api/transaction")
        .then((response) => {
          this.transaction = response.data.data;
        })
        .catch((error) => {
          console.error("Error fetching:", error);
        });
    },
    deleteTransaction(TransactionId) {
      axios
        .delete(`/api/transaction/${TransactionId}`)
        .then((response) => {
          this.fetchTransaction();
        })
        .catch((error) => {
          console.error("Error deleting Transaction:", error);
        });
    },
  },
};
</script>