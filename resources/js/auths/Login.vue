<template>
    <div class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 mx-auto">
                    <div class="card login" v-if="!loading">
                        <h1>Sign In</h1>

                        <div v-if="error" style="color: red">
                            <div class="alert alert-danger" role="alert" >
                                {{error}}
                            </div>
                        </div>

                        <form class="form-group">
                            <label>Email</label>
                            <input
                                placeholder="Email"
                                required
                                type="email"
                                class="form-control"
                                name="email"
                                v-model="email"
                            />

                            <label>Password</label>
                            <input
                                placeholder="Password"
                                v-model="password"
                                type="password"
                                class="form-control"
                                required
                            />


                            <button class="btn btn-lg btn-primary btn-block" @click.prevent="Login"
                                    :disabled="sending">Login
                            </button>
                        </form>
                    </div>
                    <div v-else>
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
    created() {
        this.loading = false;
    },

    data() {
        return {
            loading: false,
            password: null,
            email: null,
            sending: false,
            error:  null,
        }
    },

    methods: {
        Login() {
            this.loading = true;
            this.sending = true;
            this.error = null;

            if(this.email === null || this.password === null) {
                this.error = 'please enter required field values!';
            }

            axios
                .post(`/api/login`, {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    console.log("LOGIN: SUCCESS!");
                    this.$store.dispatch('storeUserData', {
                        'authData': response.data.authorisation
                    });
                    this.$router.push("/");
                })
                .catch((error) => {
                    console.log("ERROR");
                    console.log(error);
                    if(error.response.status === 401) {
                        this.error = 'Invalid credentials!';
                    } else if (error.response.status === 422) {
                        this.error = 'Incorrect login credentials format!';
                    }
                })
                .then(() => this.sending = false);
            this.loading = false;
        },


    }
}
</script>

<style>
p {
    line-height: 1rem;
}

.card {
    padding: 20px;
}

.form-group input {
    margin-bottom: 20px;
}

.login-page {
    align-items: center;
    display: flex;
    height: 100vh;
}

.login-page .wallpaper-login {
    height: 100%;
    position: absolute;
    width: 100%;
}

.login-page .fade-enter-active, .login-page .fade-leave-active {
    transition: opacity 0.5s;
}

.login-page .fade-enter, .login-page .fade-leave-to {
    opacity: 0;
}

.login-page .wallpaper-register {
    height: 100%;
    position: absolute;
    width: 100%;
    z-index: -1;
}

.login-page h1 {
    margin-bottom: 1.5rem;
}

.error {
    animation-name: errorShake;
    animation-duration: 0.3s;
}

@keyframes errorShake {
    0% {
        transform: translateX(-25px);
    }
    25% {
        transform: translateX(25px);
    }
    50% {
        transform: translateX(-25px);
    }
    75% {
        transform: translateX(25px);
    }
    100% {
        transform: translateX(0);
    }
}

</style>
