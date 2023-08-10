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
                            <div class="mb-3">
                                <label for="type" class="form-label"
                                    >Type</label
                                >
                                <select class="form-control" v-model="categoryType">
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
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
            categoryName: "",
            categoryType: "",
        };
    },
    created() {
        this.fetchCategoryData();
    },
    methods: {
        fetchCategoryData() {
            const categoryId = this.$route.params.id;

            axios
                .get(`/api/category/${categoryId}`)
                .then((response) => {
                    const category = response.data.data
                    this.categoryName = category.name;
                    this.categoryType = category.type;
                })
                .catch((error) => {
                    console.error("Error fetching category data:", error);
                });
        },
        saveCategory() {
            const categoryId = this.$route.params.id;

            axios
                .put(`/api/category/${categoryId}`, {
                    name: this.categoryName,
                    type: this.categoryType,
                })
                .then((response) => {
                    this.$router.go(-1);
                })
                .catch((error) => {
                    console.error("Error updating category:", error);
                });
        },
    },
};
</script>
