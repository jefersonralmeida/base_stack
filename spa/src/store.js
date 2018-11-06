import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import Echo from 'laravel-echo';
import io from 'socket.io-client';

Vue.use(Vuex);

const vuex = new Vuex.Store({
  state: {

    // controls the loading modal to disable / enable the application
    loading: false,

    // the backend api client
    api: null,

    // the web socket client (for real-time notifications)
    websocket: null,

    // the auth token type
    token_type: null,

    // the auth token
    access_token: null,

    // the auth refresh token
    refresh_token: null,

    // the user object
    user: null,

  },
  mutations: {
    DISABLE_APP: (state) => {
      state.loading = true;
    },
    ENABLE_APP: (state) => {
      state.loading = false;
    },
    LOAD_STATE(state) {
      if (localStorage.getItem('store')) {
        this.replaceState(Object.assign(state, JSON.parse(localStorage.getItem('store'))));
      }
    },
    INIT_API: (state) => {
      // load the api client on app state
      state.api = Axios.create({
        baseURL: process.env.VUE_APP_API_URL,
        headers: {
          Accept: 'application/json',
        },
      });

      // include the Bearer token if it's set on the state
      if (state.access_token !== null) {
        state.api.defaults.headers.Authorization = `Bearer ${state.access_token}`;
      }

      // intercept errors, and ensure the logout in case of authentication problems (401 or 403)
      // state.api.interceptors.response.use(response => response, error => {
      //   if (error.response.status === 401 || error.response.status === 403) {
      //     // TODO - Try to refresh the token first
      //     vuex.dispatch('logOut').finally(() => {
      //       router.push('/');
      //     });
      //   }
      //   return error;
      // });
    },
    INIT_WEBSOCKET: (state) => {
      if (state.access_token !== null) {
        state.websocket = new Echo({
          broadcaster: 'socket.io',
          host: 'http://localhost:6001',
          auth: {
            headers: {
              Authorization: `${state.token_type} ${state.access_token}`,
            },
          },
        });
      }
    },
    SET_TOKEN: (state, data) => {
      state.token_type = data.token_type;
      state.access_token = data.access_token;
      state.refresh_token = data.refresh_token;
    },
    REMOVE_TOKEN: (state) => {
      state.access_token = null;
      state.refresh_token = null;
      state.api.defaults.headers.common.Authorization = null;
    },
    SET_USER: (state, userData) => {
      // mutate the state
      state.user = userData;
      state.websocket.private(`App.Models.User.${state.user.id}`).notification((notification) => {
        const n = new Notification((Object.values(notification).find(item => item[0] === 'subject'))[1], {
          body: Object.values(notification).find(item => !!item && item[0] === 'line')[1],
          icon: '/img/icons/apple-touch-icon-120x120.png',
        });
        n.onclick = (ev) => {
          ev.preventDefault();
        };
      });
    },
    REMOVE_USER: (state) => {
      state.websocket.leave(`App.Models.User.${state.user.id}`);
      state.user = null;
    },
  },
  actions: {
    init: ({ commit, dispatch }) => {
      // disable the app while loading...
      commit('DISABLE_APP');

      // load the application state from local storage
      commit('LOAD_STATE');

      // setting up the api client
      commit('INIT_API');

      // setting up the socket.io client
      window.io = io;

      // ask to show notifications
      Notification.requestPermission();

      // getting user info from api
      dispatch('getUserInfo').finally(() => {
        // enabling the app, once everything is loaded
        commit('ENABLE_APP');
      });
    },
    logIn: ({ state, commit, dispatch }, { email, password }) => new Promise((resolve, reject) => {
      state.api.request({
        method: 'post',
        url: '/oauth/token',
        data: {
          grant_type: 'password',
          client_id: process.env.VUE_APP_API_CLIENT_ID,
          client_secret: process.env.VUE_APP_API_CLIENT_SECRET,
          username: email,
          password,
          scope: '*',
        },
      }).then((response) => {
        // commit the tokens to the app state
        commit('SET_TOKEN', response.data);

        // re-initialize the api client (including the token)
        commit('INIT_API');

        // init the web socket client
        commit('INIT_WEBSOCKET');

        // get the user info
        dispatch('getUserInfo').finally(() => {
          resolve();
        });
      }).catch((error) => {
        reject(error);
      });
    }),
    logOut: (context) => {
      context.commit('REMOVE_USER');
      return new Promise((resolve, reject) => {
        context.state.api.request({
          method: 'delete',
          url: '/oauth/token',
        }).then((response) => {
          resolve(response);
        }).catch((error) => {
          reject(error);
        }).finally(() => {
          context.commit('REMOVE_TOKEN');
        });
      });
    },
    getUserInfo: context => new Promise((resolve, reject) => {
      // check if the token exists, if not, do nothing
      if (!context.state.access_token) {
        resolve();
        return;
      }

      // if it don't work, query the api
      context.state.api.request({
        method: 'get',
        url: '/me',
      }).then((response) => {
        context.commit('SET_USER', response.data);
        resolve(response);
      }).catch((error) => {
        context.commit('REMOVE_USER');
        reject(error);
      });
    }),
  },
});

// init the store based on the local storage, so the state survives to page refresh
vuex.dispatch('init');

// update the local storage on each mutation, keeping the state in sync with the local storage
vuex.subscribe((mutation, state) => {
  // ignored state items
  const ignore = [
    'websocket',
  ];

  // saves the state on local storage
  localStorage.setItem('store', JSON.stringify(state, (key, value) => (ignore.includes(key) ? null : value)));
});

export default vuex;
