<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }">JustBnb</router-link>


            <div v-if="!userAuthData">
                <router-link class="btn nav-button" :to="{ name: 'login'}">
                    Login
                </router-link>

                <router-link class="btn nav-button" :to="{ name: 'register'}">
                    Register
                </router-link>

            </div>

            <div v-if="userAuthData">
                <span class="btn nav-button" @click="Logout">Logout</span>

                <router-link class="btn nav-button" :to="{ name: 'basket' }">
                    Basket
                    <span v-if="itemsInBasket" class="badge badge-secondary"> {{ itemsInBasket }}</span>
                </router-link>
            </div>

        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>

    </div>
</template>


<script>
import {mapState, mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        }),
        ...mapGetters({
            userAuthData: 'userAuthData'
        })
    },

    data() {
        return {
            showLoginRegister: false,
        }
    },

    methods: {
        Logout() {
            if (this.userAuthData !== null) {
                // let userToken = JSON.parse(localStorage.getItem('userData')).authData.token;
                let axiosInstance = axios.create({
                    headers: {
                        Authorization : `Bearer ${this.userAuthData.authData.token}`
                    }
                });

                axiosInstance
                    .post(`/api/logout`)
                    .then(response => {
                        console.log("LOGOUT: SUCCESS!");
                        this.$store.dispatch('removeUserData', {
                            'authData': response.data.authorisation
                        });
                        this.$router.push("login");
                    });
            }
        }
    }
}
</script>

<style>

</style>
