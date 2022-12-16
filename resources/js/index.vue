<template>
    <div class="flex-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }">JustBnb</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <div v-if="!userAuthData">
                        <router-link class="btn nav-button navai" :to="{ name: 'login'}">
                            Login
                        </router-link>

                        <router-link class="btn nav-button navai" :to="{ name: 'register'}">
                            Register
                        </router-link>
                    </div>

                    <div v-if="userAuthData">

                        <router-link v-if="showUserBookings" class="btn nav-button navai" :to="{ name: 'bookings' }">
                            My Bookings
                        </router-link>

                        <router-link class="btn nav-button navai" :to="{ name: 'createBookable' }">
                            Create bookable
                        </router-link>

                        <span class="btn nav-button navai" @click="Logout">Logout</span>

                        <router-link class="btn nav-button navai" :to="{ name: 'basket' }">
                            Basket
                            <span v-if="itemsInBasket" class="badge badge-secondary"> {{ itemsInBasket }}</span>
                        </router-link>
                    </div>
                </div>
            </div>


        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>

        <footer style="background-color: #2196f3 !important; color: #fff;"
                class="index-footer page-footer font-small pt-4">
            <div class="container-fluid text-center text-md-left">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <h5 class="text-uppercase">Footer Content</h5>
                        <p>Here you can use rows and columns to organize your footer content.</p>
                    </div>
                    <hr class="clearfix w-100 d-md-none pb-3">
                    <div class="col-md-3 mb-md-0 mb-3">
                        <h5 class="text-uppercase">Links</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a href="#!">Link 1</a>
                            </li>
                            <li>
                                <a href="#!">Link 2</a>
                            </li>
                            <li>
                                <a href="#!">Link 3</a>
                            </li>
                            <li>
                                <a href="#!">Link 4</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-md-0 mb-3">
                        <h5 class="text-uppercase">Links</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="#!">Link 1</a>
                            </li>
                            <li>
                                <a href="#!">Link 2</a>
                            </li>
                            <li>
                                <a href="#!">Link 3</a>
                            </li>
                            <li>
                                <a href="#!">Link 4</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="background-color: #1e7cc6;" class="footer-copyright text-center py-3">© 2022 Copyright:
                <a href="/"> JustBnb</a>
            </div>
        </footer>
    </div>
</template>


<script>
import {mapState, mapGetters} from "vuex";

export default {
    data() {
        return {
            showLoginRegister: false,
            showUserBookings: false,
        }
    },

    created() {

        if (localStorage.getItem('userData') !== null && localStorage.getItem('userData') !== "null") {
            let axiosInstance = axios.create({
                headers: {
                    Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                }
            });
            axiosInstance
                .get(`/api/user-bookings/${JSON.parse(localStorage.getItem('userData')).authData.user_id}`)
                .then(response => {
                    this.showUserBookings = true;
                }).catch(error => {
                console.log(error);
            })
        }
    },
    computed: {
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        }),
        ...mapGetters({
            userAuthData: 'userAuthData'
        })
    },

    methods: {
        Logout() {
            if (this.userAuthData !== null) {
                // let userToken = JSON.parse(localStorage.getItem('userData')).authData.token;
                let axiosInstance = axios.create({
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('userData')).authData.authParams.token}`
                    }
                });

                axiosInstance
                    .post(`/api/logout`)
                    .then(response => {
                        console.log("LOGOUT: SUCCESS!");
                        this.$store.dispatch('removeUserData', {
                            'authData': response.data.authorisation
                        });
                        this.$router.push("/login");
                    });
            }
        }
    }
}
</script>

<style>

</style>
