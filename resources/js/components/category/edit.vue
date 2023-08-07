<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Category</h5>
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="saveCategory">
                            <div class="mb-3">
                                <label for="name" class="form-label"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="categoryName"
                                />
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
            categoryName: "",
        };
    },
    created() {
        // Ambil data kategori dari server ketika komponen di-mount
        this.fetchCategoryData();
    },
    methods: {
        fetchCategoryData() {
            // Mengambil ID dari parameter URL menggunakan $route.params
            const categoryId = this.$route.params.id;

            // Ganti dengan URL endpoint yang sesuai untuk mengambil data kategori berdasarkan ID
            axios
                .get(`/api/category/${categoryId}`)
                .then((response) => {
                    // Simpan data kategori yang diambil dari server ke variabel categoryName
                    this.categoryName = response.data.data.name;
                })
                .catch((error) => {
                    console.error("Error fetching category data:", error);
                });
        },
        saveCategory() {
            // Mengambil ID dari parameter URL menggunakan $route.params
            const categoryId = this.$route.params.id;

            // Ganti dengan URL endpoint yang sesuai untuk menyimpan data kategori yang diubah
            axios
                .put(`/api/category/${categoryId}`, {
                    name: this.categoryName,
                })
                .then((response) => {
                    // Tindakan setelah sukses menyimpan data
                    this.$router.go(-1);
                })
                .catch((error) => {
                    // Tindakan jika terjadi kesalahan
                    console.error("Error updating category:", error);
                });
        },
    },
};
</script>
