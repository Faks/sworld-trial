<template>
    <div>
        <div class="row">
            <div v-for="list in getList" class="col-sm-4" style="margin-bottom: 25px;">
                <div class="card">
                    <img src="https://placeimg.com/285/200/nature" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ list.file_name }}</h5>
                        <p class="card-text">test</p>
                    </div>
                    <div class="card-body">
                        <a class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
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
                getList: [],
                errors: [],
            }
        },
        // Fetches posts when the component is created.
        mounted() {
            axios.get('api/v1/HqUn9Op7rwPfoPIjUUOkJS6DpRCrqYRFOXJGjywIDpsh1XAbXGaXdZJuTT31/documents/list')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.getList = response.data;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        }
    }
</script>
