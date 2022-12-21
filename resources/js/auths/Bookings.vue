<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                    <div v-if="bookings.length>0">
                        <ul class="list-group" v-for="booking in bookings">
                            <li class="list-group-item m-3">
                                <div class="m-2">
                                    <h5>
                                        Booking made from {{booking.from}} to {{booking.to}}
                                    </h5>
                                    <div style="display:block" class="btn btn-primary m-3">
                                        <router-link :to="`/bookable/${booking.bookable_id}`">
                                            <h5 style="color: #fff !important;">View</h5>
                                        </router-link>
                                    </div>

                                    <div v-if="booking.review_key" style="display:block" class="btn btn-secondary m-3">
                                        <router-link :to="`/review/${booking.review_key}`">
                                            <h5 style="color: #fff !important;">Leave a review</h5>
                                        </router-link>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <div class="m-4 p-5">
                            <h3>You haven't made any bookings yet</h3>
                        </div>

                    </div>
            </div>
        </div>
    </div>

</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
    data() {
        return {
            bookings: [],
        }
    },

    created() {
        if (localStorage.getItem('userData') !== "null") {
            let axiosInstance = axios.create({
                headers: {
                    Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                }
            });
            axiosInstance
                .get(`/api/user-bookings/${JSON.parse(localStorage.getItem('userData')).authData.user_id}`)
                .then(response => {
                    // alert(response.data.data[0].review_key);
                    // alert(response.data.data[0].bookable_id);

                    this.bookings = response.data.data;
                }).catch(error => {
                console.log(error);
            })
        }
    },

    methods: {

    }
}
</script>

<style>

</style>
