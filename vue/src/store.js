import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from 'vuex-persistedstate'


Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: null
  },
  plugins: [createPersistedState({
    storage: window.sessionStorage,
  })],

  mutations: {
    SET_USER(state, obj) {
      state.user = obj
    }
  },
  actions: {
    setUser({ commit }, obj) {
      return new Promise((resolve, reject) => {
        commit('SET_USER', obj)
        resolve('user-set')
      })
    }
  }
})
