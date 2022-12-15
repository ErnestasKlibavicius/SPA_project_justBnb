<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div v-if="loading">
                Data is loading...
            </div>
            <div v-else>
                <div class="form-group">
                    <label for="Title">Title</label>
                    <input v-model="bookable.title" type="text" class="form-control" id="title" aria-describedby="title" placeholder="title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3">
                        {{bookable.description}}
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="price">Nightly rate</label>
                    <input v-model="bookable.price" type="number" class="form-control" id="price" placeholder="price">
                </div>

                <button type="submit" class="btn btn-primary" :disabled="update" @click="updateBooking">Update</button>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data() {
        return {
            bookable: null,
            loading: null,
            update: false,
        };
    },

    created() {
        this.$store.dispatch('removeFromBasket', this.$route.params.id);
        this.loading = true;


        axios
            .get(`/api/bookables/${this.$route.params.id}`)
            .then(response => {
                this.bookable = response.data.data;
                this.loading = false;
            });
    },
    computed: {

    },
    methods: {
        updateBooking(){
            this.update = true;

            let axiosInstance = axios.create({
                headers: {
                    Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                }
            });

            axiosInstance.put(`/api/bookables/${this.$route.params.id}`, {
                title:  this.bookable.title,
                description: this.bookable.description,
                price: this.bookable.price
            }).then(response => {
                this.$router.push({
                    path:`/bookable/${this.bookable.id}`
                });
            }).catch(err => {
                console.log(err);
            })
            this.update = false;
        }
    },
}
</script>


<style scoped>
.warning {
    font-size: 0.7rem;
}
</style>
