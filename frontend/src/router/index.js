import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import Login from '../components/Login'
import SourceTracking from "../components/sourceTracking/SourceTracking";
import NextToDo from "../components/toDo/Overview";
import Administration from "../components/administration/Administration";
import SummaryOverview from "../components/summary/SummaryOverview";

Vue.use(Router);

let router = new Router({
  routes: [
    {
      path: '/',
      name: 'Quellenerfassung',
      component: SourceTracking,
      meta: {
        requiresAuth: true
      }
    }, {
      path: '/nextStep',
      name: 'Aufgaben',
      component: NextToDo,
      meta: {
        requiresAuth: true
      }
    }, {
      path: '/login',
      name: 'Login',
      component: Login
    }, {
      path: '/admin',
      name: 'Programmverwaltung',
      component: Administration,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/summary',
      name: 'Auswertung',
      component: SummaryOverview,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    }
  ]
});

router.beforeEach((to, from, next) => {
  store.commit('auth/checkLoginStatus');
  let isLoggedIn = store.state.auth.isLoggedIn;
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (isLoggedIn) {
      next();
    } else {
      next('/login')
    }
  } else if (to.name.toLowerCase() === 'login' && isLoggedIn) {
    store.dispatch('auth/logout').then(next('/'));
  } else {
    next()
  }
});

export default router
