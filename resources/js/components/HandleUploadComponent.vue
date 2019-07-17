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
        </div>
    </div>
</template>

<script>
export default {
    props: ["api_token"],
    data() {
        return {
            pdf: ""
        };
    },
    methods: {
        handleFormSubmit() {
            let formData = new FormData();
            formData.append("pdf", this.pdf);

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
                .then(function(data) {
                    console.log(data.data);
                    location.reload();
                })
                .catch(function() {
                    console.log("FAILURE!!");
                });
        },

        onChangeFileUpload() {
            this.pdf = this.$refs.pdf.files[0];
            console.log(this.pdf);
        }
    }
};
</script>
