<template>
    <div>
        <div class="row" style="margin-bottom: 25px;">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="file" class="form-check-label"
                        >Please select new document:</label
                    >
                    <input
                        name="pdf"
                        type="file"
                        id="file"
                        ref="pdf"
                        accept="application/pdf"
                        v-on:change="onChangeFileUpload()"
                        class="form-control"
                    />
                </div>
                <button @click="handleFormSubmit" class="btn btn-primary">
                    add new document
                </button>
            </div>

            <ul v-if="errors !== null" class="list-group list-group-flush">
                <li class="list-group-item list-group-item-danger">
                    {{ errors }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ["api_token"],
    data() {
        return {
            form: {
                pdf: ""
            },
            errors: null,
            success: false
        };
    },
    methods: {
        handleFormSubmit() {
            let formData = new FormData();
            formData.append("pdf", this.form.pdf);

            axios
                .post(
                    "api/v1/" + this.api_token + "/documents/store",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }
                )
                .then(response => {
                    this.errors = false;
                    this.success = response.data.success;
                    location.reload();
                })
                .catch(error => {
                    this.errors = error.response.data.errors.pdf[0];
                    this.success = false;
                });
        },
        onChangeFileUpload() {
            this.form.pdf = this.$refs.pdf.files[0];
        }
    }
};
</script>
