<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div v-if="loading">
                Data is loading...
            </div>
            <div v-else>
                <div class="form-group">
                    <label for="Title">Title</label>
                    <input v-model="bookable.title" type="text" class="form-control" id="title" aria-describedby="title"
                           placeholder="title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea v-model="bookable.description" class="form-control" id="description" rows="3">

                    </textarea>
                </div>

                <div class="form-group">
                    <label for="price">Nightly rate</label>
                    <input v-model="bookable.price" type="number" class="form-control" id="price" placeholder="price">
                </div>

                <button type="submit" class="btn btn-primary" :disabled="post" @click="createBooking">Update</button>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data() {
        return {
            loading: false,
            post: false,
            bookable: {
                title: null,
                price: 0,
                description: null
            }
        };
    },

    created() {
        // this.loading = true;


    },
    computed: {},
    methods: {
        createBooking() {
            this.post = true;

            let axiosInstance = axios.create({
                headers: {
                    Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                }
            });

            axiosInstance.post(`/api/bookables`, {
                title: this.bookable.title,
                description: this.bookable.description,
                price: this.bookable.price,
                user_id: JSON.parse(localStorage.getItem('userData')).authData.user_id
            }).then(response => {
                this.post = false;
                this.$router.push({
                    path: `/bookable/${response.data.id}`
                });
            }).catch(err => {
                console.log(err);
            })

        },
    }
}
</script>


<style scoped>
.warning {
    font-size: 0.7rem;
}
</style>
