<template>
    <div class="container">
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Chart of Account</h5>
                    <router-link to="/create-coa" class="btn btn-primary">Add</router-link>
                </div>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Code</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Category</h6>
                        </th>
                        <th class="border-bottom-0">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in coa" :key="item.id">
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ item.code }}</h6></td>
                        <td class="border-bottom-0">
                            {{ item.name }}
                        </td>
                        <td class="border-bottom-0">
                            {{ item.category.name }}
                        </td>
                        <td class="border-bottom-0">
                            <router-link :to="{ name: 'edit-coa', params: { id: item.id } }" class="btn btn-sm btn-warning mx-2">Edit</router-link>
                            <button @click="deleteCoa(item.id)" class="btn btn-sm btn-danger">Delete</button>
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
      coa: [],
    };
  },
  created() {
    // Panggil metode untuk mengambil data kategori dari server ketika komponen di-mount
    this.fetchCoa();
  },
  methods: {
    fetchCoa() {
      // Ganti dengan URL endpoint yang sesuai untuk mengambil daftar kategori dari server
      axios
        .get("/api/coa")
        .then((response) => {
          this.coa = response.data.data;
        })
        .catch((error) => {
          console.error("Error fetching:", error);
        });
    },
    deleteCoa(coaId) {
      // Ganti dengan URL endpoint yang sesuai untuk menghapus data kategori berdasarkan ID
      axios
        .delete(`/api/coa/${coaId}`)
        .then((response) => {
          // Tindakan setelah sukses menghapus data
          console.log(response);

          // Panggil kembali metode untuk memperbarui daftar kategori setelah penghapusan berhasil
          this.fetchCoa();
        })
        .catch((error) => {
          // Tindakan jika terjadi kesalahan
          console.error("Error deleting coa:", error);
        });
    },
  },
};
</script>