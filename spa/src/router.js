import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Login from './views/Login.vue';
import Register from './views/Register.vue';
import Request from './views/Request.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user')) {
          next();
        } else {
          next('/');
        }
      },
    },
    {
      path: '/register',
      name: 'login',
      component: Register,
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user')) {
          next();
        } else {
          next('/');
        }
      },
    },
    {
      path: '/request',
      name: 'request',
      component: Request,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './views/About.vue'),
    },
  ],
});
