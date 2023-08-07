<template>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Transaction</h5>
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="saveTransaction">
              <div class="mb-3">
                <label for="name" class="form-label">Tanggal</label>
                <input type="date" class="form-control" v-model="date" />
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Chart of Account</label>
                <select class="form-control" v-model="coa_id">
                  <option v-for="item in coa" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Desc</label>
                <textarea class="form-control" v-model="desc"></textarea>
              </div>
              <div class="mb-3" v-if="coa_id === 4 || coa_id === 5 || coa_id === 6 || coa_id === 7 || coa_id === 8">
                <label for="name" class="form-label">Debit</label>
                <input type="number" class="form-control" v-model="debit" />
              </div>
              <div class="mb-3" v-if="coa_id === 1 || coa_id === 2 || coa_id === 3">
                <label for="name" class="form-label">Credit</label>
                <input type="number" class="form-control" v-model="credit" />
              </div>
              <button type="submit" class="btn btn-primary">
                Submit
              </button>
            </form>
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
      date: "",
      coa_id: "",
      desc: "",
      credit: "",
      debit: "",
      coa: [],
    };
  },
  created() {
    this.fetchCoa();
    this.fetchTransaction();
  },
  methods: {
    fetchCoa() {
      axios
        .get("/api/coa")
        .then((response) => {
          this.coa = response.data.data;
        })
        .catch((error) => {
          console.error("Error fetching categories:", error);
        });
    },
    fetchTransaction() {
      const transactionId = this.$route.params.id;
      axios
        .get(`/api/transaction/${transactionId}`)
        .then((response) => {
          const transaction = response.data.data;
          this.date = transaction.date;
          this.coa_id = transaction.coa.id;
          this.desc = transaction.desc;
          this.debit = transaction.debit;
          this.credit = transaction.credit;
        })
        .catch((error) => {
          console.error("Error fetching categories:", error);
        });
    },
    saveTransaction() {
      const transactionId = this.$route.params.id;
      const url = `/api/transaction/${transactionId}`;

      const data = {
        date: this.date,
        coa_id: this.coa_id,
        desc: this.desc,
        debit: this.debit,
        credit: this.credit,
      };
      axios
        .put(url, data)
        .then((response) => {
          console.log(response);
          this.$router.push("/transaction");
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>  