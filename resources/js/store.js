export default {
    state: {
        lastSearch: {
            from: null,
            to: null,
        },
        basket: {
            items: []
        },

        userData: null

    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },

        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload) {
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload);
        },
        setBasket(state, payload) {
            state.basket = payload;
        },
        storeUserData(state, payload) {
            state.userData = payload;
        },
        removeUserData(state, payload) {
            state.userData = null;
        }
    },
    actions: {
        setLastSearch(context, payload) {
            context.commit('setLastSearch', payload);
            localStorage.setItem('lastSearch', JSON.stringify(payload));
        },
        loadStoredState(context) {
            const lastSearch = localStorage.getItem('lastSearch');
            if (lastSearch) {
                context.commit('setLastSearch', JSON.parse(lastSearch));
            }

            const basket = localStorage.getItem('basket');
            if(basket) {
                context.commit('setBasket', JSON.parse(basket));
            }

            const authData = localStorage.getItem('userData');
            if (authData) {
                context.commit('storeUserData', JSON.parse(authData));
            }
        },
        addToBasket({ commit, state}, payload) {
            // context.state, context.commit
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },

        storeUserData({ commit, state}, payload) {
            commit('storeUserData', payload);
            localStorage.setItem('userData', JSON.stringify(state.userData));
        },

        removeUserData({ commit, state}, payload) {
            commit('removeUserData', payload);
            localStorage.setItem('userData', null);
        },

        removeFromBasket({ commit, state}, payload) {
            commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },

        clearBasket({commit, state}, payload) {
            commit("setBasket", { items: [] });
            localStorage.setItem("basket", JSON.stringify(state.basket));
        }
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        userAuthData: (state) => state.userData,
        inBasketAlready(state) {
            return function (id) {
                return state.basket.items.reduce(
                    (result, item) => result || item.bookable.id === id,
                    false
                );
            }
        }
    }
}
