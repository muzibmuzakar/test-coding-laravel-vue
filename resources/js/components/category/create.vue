<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">New Category</h5>
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
export default {
    data() {
        return {
            categoryName: "",
        };
    },
    methods: {
        saveCategory() {
            axios
                .post("/api/category", { name: this.categoryName })
                .then((response) => {
                    this.$router.go(-1);
                })
                .catch((error) => {
                    console.error("Error saving category:", error);
                });
        },
    },
};
</script>
