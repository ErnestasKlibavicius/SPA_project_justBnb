<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">

                        <span v-if="author && !is_owner">
                            Booking Author: {{ author }}
                        </span>

                        <div v-if="is_owner" class="alert alert-success">
                            This booking belongs to you
                        </div>
                        <h2>{{ bookable.title }}</h2>
                        <hr>
                        <article>{{ bookable.description }}</article>
                    </div>
                    <div v-else>
                        Loading...
                    </div>
                </div>
            </div>
            <review-list :bookable-id="this.$route.params.id"></review-list>
        </div>
        <div class="col-md-4 pb-4">
            <div v-if="is_owner">
                <div class="btn btn-primary m-2" style="display: block">
                    <router-link :to="`/bookable/${this.$route.params.id}/edit`">
                        <h5 style="color: #fff !important;">Edit</h5>
                    </router-link>
                </div>
                <div class="btn btn-danger m-2" style="display: block" @click="deleteBookable">
                    delete
                </div>
            </div>

            <availability :bookable-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4">
            </availability>

            <Transition>
                <price-breakdown :price="price" v-if="price" class="mb-4"></price-breakdown>
            </Transition>

            <Transition>
                <button class="btn btn-outline-secondary btn-block" v-if="price" @click="addToBasket"
                        :disabled="inBasketAlready">Book now
                </button>
            </Transition>


            <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready" @click="removeFromBasket">Remove
                from basket
            </button>

            <div v-if="inBasketAlready" class="mt-4 text-muted warning">
                Seems like you've added this object to basket already. If you want to change dates, remove from basket
                first.
            </div>


        </div>
    </div>
</template>

<script>
import Availability from "./Availability.vue";
import ReviewList from "./ReviewList.vue";
import PriceBreakdown from "./PriceBreakdown.vue";
import {mapState} from "vuex";

export default {
    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },
    // in here we define data that needs to be reactive
    data() {
        return {
            bookable: null,
            loading: false,
            is_owner: false,
            author: null,
            bookableUser: null,
            price: null
        };
    },

    created() {
        this.loading = true;
        axios
            .get(`/api/bookables/${this.$route.params.id}`)
            .then(response => {
                this.bookable = response.data.data;
                if (localStorage.getItem('userData') !== "null") {
                    this.bookableUser = response.data.data.user_id;
                    if (this.bookableUser === JSON.parse(localStorage.getItem('userData')).authData.user_id) {
                        this.is_owner = true;
                    }
                }
                this.loading = false;
            });

        axios
            .get(`/api/bookables/${this.$route.params.id}/author`)
            .then(response => {
                if (response.data.data.id === this.bookableUser) {
                    this.author = response.data.data.name;
                }
            });
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch"
        }),
        inBasketAlready() {
            if (this.bookable === null) {
                return false;
            }
            return this.$store.getters.inBasketAlready(this.bookable.id);
        }
    },
    methods: {
        async checkPrice(hasAvailability) {
            if (!hasAvailability) {
                this.price = null;
                return;
            }
            try {
                if (localStorage.getItem('userData') !== "null") {

                    let axiosInstance = axios.create({
                        headers: {
                            Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                        }
                    });
                    this.price = (await axiosInstance.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
                } else {
                    this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
                }

            } catch (err) {
                this.price = null;
            }
        },
        addToBasket() {
            this.$store.dispatch('addToBasket', {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });
        },
        removeFromBasket() {
            this.$store.dispatch('removeFromBasket', this.bookable.id);
        },

        deleteBookable() {
            if (confirm('are you sure?')) {
                let axiosInstance = axios.create({
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                    }
                });

                axiosInstance.delete(`/api/bookables/${this.bookable.id}`)
                    .then(response => {
                        this.$router.push("/");
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    },
}
</script>


<style scoped>
.warning {
    font-size: 0.7rem;
}
</style>
