<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Product</div>

                    <div class="card-body">

                        <div v-if="message" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Product {{ message }} successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeMessage">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form class="needs-validation" novalidate>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" v-model="name" class="form-control" id="name"
                                       placeholder="Enter product name">
                                <div class="text-danger" v-if="errors && errors.name">
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manufactured">Manufactured</label>
                                <input type="number" v-model="manufactured" class="form-control" id="manufactured"
                                       placeholder="Manufactured year" min="1900" :max="thisYear">

                                <div class="text-danger" v-if="errors && errors.manufactured">
                                    {{ errors.manufactured[0] }}
                                </div>
                            </div>

                            <div class="form-check pb-3">
                                <img :src="'/storage/'+photoUrl" alt="no photo" class="img-thumbnail">
                            </div>

                            <div class="form-check">
                                <label for="photo">Change photo</label>
                                <input type="file" @change="getPhoto($event)" class="form-control-file" id="photo">

                                <div class="text-danger" v-if="errors && errors.photo">
                                    {{ errors.photo[0] }}
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary" @click.stop.prevent="update">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "edit",

    props: {
        productId: null,
    },

    data() {
        return {
            thisYear: moment().year(),

            errors: null,

            name: '',
            manufactured: moment().year(),
            photo: null,
            photoUrl: null,

            message: ''
        }
    },

    created() {
        this.initData();
    },

    methods: {
        initData() {
            axios.get('/api/products/'+this.productId).then(response => {
                const product = response.data.item;

                this.name = product.name;
                this.manufactured = product.manufactured;
                this.photoUrl = product.photo
            })
        },

        update() {
            let form = new FormData();

            form.append('name', this.name)
            form.append('manufactured', this.manufactured)
            if (this.photo) {
                form.append('photo', this.photo);
            }

            axios.post('/api/products/'+this.productId, form, {headers: {
                    'Content-Type' : 'multipart/form-data'
                }}).then(res => {
                this.message = res.data.message;
            }).catch(error => {
                this.errors = error.response.data.errors;
            })
        },

        getPhoto(event) {
            this.photo = event.target.files[0];
        },

        closeMessage() {
            this.message = ''
        }
    }
}
</script>

<style scoped>

</style>
