<template>
  <div class="container">
      <div class="d-flex align-items-stretch">
          <div class="card w-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between">
                  <h5 class="card-title fw-semibold mb-4">Report</h5>
                  <div class="tgl d-flex">
                      <button @click="exportToExcel" class="btn btn-success">Export</button>
                  </div>
              </div>
              <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Category</h6>
                      </th>
                      <th class="border-bottom-0">
                        <input type="month" class="form-control bulan" v-model="selectedMonth" @change="fetchReport">
                        <h6 class="fw-semibold mb-0">Amount</h6>
                      </th>
                      <th class="border-bottom-0">
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in category" :key="item.id">
                      <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ item.name }}</h6></td>
                      <td class="border-bottom-0">
                        {{ totalCreditsByCategory[item.id] || 0 }}
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

<style>
.bulan{
  width: 150px;
  margin-bottom: 10px;
}
</style>

<script>
import axios from "axios";

export default {
  data() {
    return {
      selectedMonth: "",
      category: [],
      totalCreditsByCategory: {},
    };
  },
  created() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    this.selectedMonth = `${year}-${month}`;
    this.fetchCategories();
  },
  methods: {
    fetchCategories() {
      axios
        .get("/api/category")
        .then((response) => {
          this.category = response.data.data;
          this.fetchReport();
        })
        .catch((error) => {
          console.error("Error fetching categories:", error);
        });
    },
    fetchReport() {
      const self = this;

      this.category.forEach((item) => {
        const url = `/api/report/${item.id}/${
          this.selectedMonth.split("-")[1]
        }`;
        axios
          .get(url)
          .then((response) => {
            const dataReport = response.data.data;
            const totalAmount = dataReport.reduce((total, transaction) => {
              const amount =
                transaction.type === "credit"
                  ? transaction.debit
                  : transaction.credit || 0;
              return total + amount;
            }, 0);
            self.totalCreditsByCategory[item.id] = totalAmount;
          })
          .catch((error) => {
            console.error("Error fetching reports:", error);
          });
      });
    },
  },
};
</script>
