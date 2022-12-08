<template>
    <div>
        <success v-if="success">
            You've left a review, thank you very much!
        </success>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-if="!success && !error">
            <div :class="[{'col-md-4' : twoColumns}, {'d-none' : oneColumn}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading..</div>
                        <div v-else>
                            <div v-if="!alreadyReviewed">
                                <p>
                                    Stayed at <router-link
                                        :to="{ name: 'bookable', params: {id: booking.bookable.bookable_id} }"> {{
                                        booking.bookable.title }}</router-link>
                                </p>
                                <p> From {{ booking.from }} to {{ booking.to }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8' : twoColumns}, {'col-md-12': oneColumn}]">
                <div v-if="loading">Loading...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        <h3>You've already left a review for this booking!</h3>
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
                            <star-rating :rating="review.rating" class="fa-3x"
                                v-on:rating:changed="review.rating = $event">
                            </star-rating>
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted">Describe your experience with</label>
                            <textarea name="content" cols="30" rows="10" class="form-control" v-model="review.content"
                                :class="[{'is-invalid': errorFor('content')}]">
                            </textarea>
                            <v-errors :errors="errorFor('content')"></v-errors>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" @click.prevent="submit"
                            :disabled="sending">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { is404, is422 } from "./../shared/utils/response";
import ValidationErrors from "./../shared/mixins/ValidationErrors";

export default {
    mixins: [ValidationErrors],
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null
            },
            existingReview: null,
            loading: false,
            booking: null,
            error: false,
            sending: false,
            success: false
        }
    },
    async created() {
        this.review.id = this.$route.params.id;
        this.loading = true;

        try {

            if(localStorage.getItem('userData') !== "null") {
                let axiosInstance = axios.create({
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.token}`
                    }
                });

                this.existingReview = (await axiosInstance.get(`/api/reviews/${this.review.id}`)).data.data;
            } else {
                this.existingReview = (await axios.get(`/api/reviews/${this.review.id}`)).data.data;
            }

        } catch (err) {
            if (is404(err)) {
                try {
                    if(localStorage.getItem('userData') !== "null") {
                        let axiosInstance = axios.create({
                            headers: {
                                Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.token}`
                            }
                        });

                        this.booking = (await axiosInstance.get(`/api/booking-by-review/${this.review.id}`)).data.data;
                    }else {
                        this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data;
                    }

                } catch (err) {
                    this.error = !is404(err);
                }

            } else {
                this.error = true;
            }
        }
        this.loading = false;
    },

    computed: {
        alreadyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return this.existingReview !== null;
        },
        hasBooking() {
            return this.booking !== null;
        },
        oneColumn() {
            return !this.loading && this.alreadyReviewed;
        },
        twoColumns() {
            return this.loading || !this.alreadyReviewed;
        }
    }, methods: {
        submit() {
            this.sending = true;
            this.errors = null;
            this.success = false;

            if(localStorage.getItem('userData') !== "null") {
                let axiosInstance = axios.create({
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.token}`
                    }
                });

                axiosInstance
                    .post(`/api/reviews`, this.review)
                    .then(response => {
                        this.success = response.status === 201;
                    })
                    .catch((err) => {
                        if (is422(err)) {
                            const errors = err.response.data.errors;

                            if (errors['content'] && _.size(errors) === 1) {
                                this.errors = errors;
                                return;
                            }
                        }

                        this.error = true;
                    })
                    .then(() => this.sending = false);
            } else {
                axios
                    .post(`/api/reviews`, this.review)
                    .then(response => {
                        this.success = response.status === 201;
                    })
                    .catch((err) => {
                        if (is422(err)) {
                            const errors = err.response.data.errors;

                            if (errors['content'] && _.size(errors) === 1) {
                                this.errors = errors;
                                return;
                            }
                        }

                        this.error = true;
                    })
                    .then(() => this.sending = false);
            }
        }
    },
}
</script>
