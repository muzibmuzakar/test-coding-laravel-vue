<template>
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">New Transaction</h5>
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
                    <optgroup v-for="type in coaType" :label="type" :key="type">
                      <option v-for="coa in coaByType(type)" :key="coa.id" :value="coa.id">{{ coa.name }}</option>
                    </optgroup>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="name" class="form-label">Desc</label>
                  <textarea class="form-control" v-model="desc"></textarea>
                </div>
                <div class="mb-3" v-if="coa_id && coa.find(item => item.id === coa_id).category.type === 'debit'">
                  <label for="name" class="form-label">Debit</label>
                  <input type="number" class="form-control" v-model="debit" />
                </div>
                <div class="mb-3" v-if="coa_id && coa.find(item => item.id === coa_id).category.type === 'credit'">
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
    },
    computed: {
      coaType() {
        return [...new Set(this.coa.map(coa => coa.category.name))];
      }
    },
    methods: {
      fetchCoa() {
        axios
          .get("/api/coa")
          .then((response) => {
            this.coa = response.data.data;
          })
          .catch((error) => {
            console.error("Error fetching coa:", error);
          });
      },
      coaByType(type) {
        return this.coa.filter(coa => coa.category.name === type);
      },
      saveTransaction() {
        const url = "/api/transaction";
  
        const data = {
          date: this.date,
          coa_id: this.coa_id,
          desc: this.desc,
          debit: this.debit,
          credit: this.credit,
        };
        axios
          .post(url, data)
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