<template>
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Edit Chart of Account</h5>
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="saveCoa">
                <div class="mb-3">
                  <label for="name" class="form-label">Code</label>
                  <input type="text" class="form-control" v-model="code" />
                </div>
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" v-model="name" />
                </div>
                <div class="mb-3">
                  <label for="name" class="form-label">Category</label>
                  <select class="form-control" v-model="category">
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                  </select>
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
        code: "",
        name: "",
        category: "",
        categories: [],
      };
    },
    created() {
      this.fetchCoa();
      this.fetchCategories();
    },
    methods: {
      fetchCategories() {
        axios
          .get("/api/category")
          .then((response) => {
            this.categories = response.data.data;
          })
          .catch((error) => {
            console.error("Error fetching categories:", error);
          });
      },
      fetchCoa() {
        const coaId = this.$route.params.id;
        const url = `/api/coa/${coaId}`;
  
        axios
          .get(url)
          .then((response) => {
            const coaData = response.data.data;
            this.code = coaData.code;
            this.name = coaData.name;
            this.category = coaData.category.id;
          })
          .catch((error) => {
            console.error("Error fetching coa:", error);
          });
      },
      saveCoa() {
        const coaId = this.$route.params.id;
        const url = `/api/coa/${coaId}`;
  
        const data = {
          code: this.code,
          name: this.name,
          category_id: this.category,
        };
  
        axios
          .put(url, data)
          .then((response) => {
            this.$router.push("/coa");
          })
          .catch((error) => {
            console.error("Error updating coa:", error);
          });
      },
    },
  };
  </script>
  