<template>
    <div class="container">
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                    <router-link to="/new-category" class="btn btn-primary">Add</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="category in categories" :key="category.id">
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ category.id }}</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{{ category.name }}</h6>
                        </td>
                        <td class="border-bottom-0">
                            <router-link :to="{ name: 'edit-category', params: { id: category.id } }" class="btn btn-sm btn-warning mx-2">Edit</router-link>
                            <button @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</button>
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
      categories: [],
    };
  },
  created() {
    // Panggil metode untuk mengambil data kategori dari server ketika komponen di-mount
    this.fetchCategories();
  },
  methods: {
    fetchCategories() {
      // Ganti dengan URL endpoint yang sesuai untuk mengambil daftar kategori dari server
      axios
        .get("/api/category")
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.error("Error fetching categories:", error);
        });
    },
    deleteCategory(categoryId) {
      // Ganti dengan URL endpoint yang sesuai untuk menghapus data kategori berdasarkan ID
      axios
        .delete(`/api/category/${categoryId}`)
        .then((response) => {
          // Tindakan setelah sukses menghapus data
          console.log(response);

          // Panggil kembali metode untuk memperbarui daftar kategori setelah penghapusan berhasil
          this.fetchCategories();
        })
        .catch((error) => {
          // Tindakan jika terjadi kesalahan
          console.error("Error deleting category:", error);
        });
    },
  },
};
</script>