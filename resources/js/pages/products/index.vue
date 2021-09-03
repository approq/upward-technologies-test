<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Products

                        <a type="button" class="btn btn-sm btn-primary float-right" href="/products/create">Create</a>
                    </div>

                    <div class="card-body">

                        <div v-if="message" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Product {{ message }} successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeMessage">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <table v-if="items.length" class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Manufactured</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in items" >
                                <th scope="row">{{ item.id }}</th>
                                <td><img :src="'/storage/'+item.photo" alt="no photo" class="img-thumbnail" height="100" width="100"></td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.manufactured }}</td>
                                <td>
                                    <a type="button" class="btn btn-sm btn-primary" :href="'/products/'+item.id">Update</a>
                                    <button type="button" class="btn btn-sm btn-danger ml-2" @click="itemDelete(item.id)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <span v-else>No Products found.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "index",

    data() {
        return {
            items: [],
            message: '',
        }
    },

    created() {
        this.initData();
    },

    methods: {
        initData() {
            axios.get('/api/products').then(response => {
                this.items = response.data.items;
            }).catch(error => {
                console.log(error);
            })
        },

        itemDelete(itemId) {
            axios.delete('/api/products/'+itemId).then(response => {
                this.message = response.data.message;

                this.initData();
            }).catch(error => {
                console.log(error)
            })
        },

        closeMessage() {
            this.message = ''
        }
    }
}
</script>

<style scoped>

</style>
