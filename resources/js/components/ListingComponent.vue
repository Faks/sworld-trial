<template>
    <div>
        <div class="row">
            <div v-for="list in getList" class="col-sm-4"
                 style="margin-bottom: 25px;">
                <div class="card" type="button"
                     data-toggle="modal"
                     v-bind:data-target="'#Modal'+ list.id +''">
                    <img src="https://placeimg.com/285/200/nature" class="card-img-top" alt="...">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ list.file_name }}</h5>
                    </div>
                    
                    <div class="card-body">
                        <a v-bind:href="''+ list.file_path +'/' + list.file_name +''" class="card-link">Download</a>
                    </div>
                
                </div>
            </div>
        </div>
        
        <!-- The Modal -->
        <main v-for="list in getList">
            <!-- Modal -->
            <div class="modal fade"
                 v-bind:id="'Modal'+list.id +''"
                 tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div
                    class="modal-dialog modal-lg"
                    role="document">
                    <div class="modal-content">
                        <object type="application/pdf"
                                v-bind:data="''+ list.file_path +'/' + list.file_name +''"
                                width="100%"
                                height="100%"
                                style="height: 85vh;">No Support
                        </object>
                    </div>
                </div>
            </div>
        </main>
    
    
    </div>
</template>

<script>
    export default {
        props: ['api_token'],
        data() {
            return {
                getList: [],
                errors: [],
                fetch: false,
            }
        },
        // Fetches posts when the component is created.
        mounted() {
            axios.get('api/v1/' + this.api_token + '/documents/list')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.getList = response.data;
                    this.fetch = true;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        }
    }
</script>
