<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
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
            <availability :bookable-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4">
            </availability>

            <Transition>
                <price-breakdown :price="price" v-if="price" class="mb-4"></price-breakdown>
            </Transition>

            <Transition>
                <button class="btn btn-outline-secondary btn-block" v-if="price" @click="addToBasket"
                    :disabled="inBasketAlready">Book now</button>
            </Transition>


            <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready" @click="removeFromBasket">Remove
                from basket</button>

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
import { mapState } from "vuex";

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
            price: null
        };
    },

    created() {
        this.loading = true;
        axios
            .get(`/api/bookables/${this.$route.params.id}`)
            .then(response => {
                this.bookable = response.data.data;
                this.loading = false;
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
                if(localStorage.getItem('userData') !== "null") {
                    let axiosInstance = axios.create({
                        headers: {
                            Authorization : `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.token}`
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
        }
    },
}
</script>


<style scoped>
.warning {
    font-size: 0.7rem;
}
</style>
