import axios from "../auth-axios";
import router from "../../router";
import {EventBus} from "../../event-bus";

const state = {
  isLoggedIn: false,
  isAdmin: false,
  backendBaseUrl: 'http://localhost:8000/',
  tokenExpiredAt: null,
  me: null,
  myNextToDo: null
};

const getters = {
  getMe: (state) => state.me,
  getMyProgress: (state, getters, rootState, rootGetters) => {
    if (state.me) {
      return state.me.progress / rootGetters['steps/getStepsCount'] * 100
    }
    return 0
  },
  getMyNextToDo: (state) => {
    return state.myNextToDo
  }
};

const actions = {
  async login ({commit, dispatch}, credentials) {
    let response = await axios.post('auth/login', credentials)
      .catch((error) => {
        handleError(error);
        commit('checkLoginStatus');
      });

    if (!response || !response.data.access_token) {
      throw new Error("'Login failed!'")
    }

    handleLogin(commit, response.data.access_token);
    commit('setTokenExpirationTime', response.data.expires_in);
    await dispatch('getMe');
    router.push('/');

  },
  async logout ({commit}) {
    await axios.get('auth/logout');
    handleLogout(commit);
  },
  refresh ({commit, rootState}, payload) {
    console.log('auth/refresh');
    axios.get('auth/refresh')
      .then((response) => {
        if (!response.data.access_token) {
          console.log("Refresh failed!");
          throw new Error("'Refresh failed!'")
        }
        handleLogin(commit, response.data.access_token);
        commit('setTokenExpirationTime', response.data.expires_in);
        if (payload) {
          rootState.dispatch(
            payload.uri  ? payload.uri : 'auth/logout',
            payload.body  ? payload.body : ''
          );
          router.push('/')
        }
      })
      .catch((error) => {
        handleError(error);
        commit('checkLoginStatus');
        router.go('/login')
      });
  },
  async getMe ({commit, dispatch}) {
    let response = await axios.get('auth/me')
      .catch((error) => {
        EventBus.$emit('getMeError',  error.response ? error.response.data.error : error.message);
      });
    if (response) {
      commit('setMe', response.data);
    }
    await dispatch('getMyNextToDo');
  },
  async getMyNextToDo ({commit, state, dispatch, rootState}) {
    if (!rootState.steps.all || rootState.steps.all.length < 1) {
      await dispatch('steps/getAllSteps', null, {root: true});
    }
    let toDo = rootState.steps.all.find((value) => value.position === state.me.progress);
    if (!toDo) {
      commit('setMyNextToDo', {
        type: 'notFound',
        object: undefined
      });
    }
    else if (toDo.task_id !== 0) {
      dispatch('tasks/getTaskById', toDo.task_id, {root: true}).then((response) => {
        commit('setMyNextToDo', {
          type: 'task',
            object: response.data
        })
      });
    }
    else if (toDo.questionnaire_id !== 0) {
      dispatch('questionnaires/getQuestionnaire', toDo.questionnaire_id, {root: true}).then((response) => {
        commit('setMyNextToDo', {
          type: 'questionnaire',
          object: response.data
        })
      });
    }
  },
  async finishStep ({commit, dispatch}) {
    await axios.put('auth/me').catch((error) => {
      handleError('finishStepError', error, dispatch);
    });
    await dispatch('getMe');
  }
};

const mutations = {
  checkLoginStatus (state) {
    state.isLoggedIn = localStorage.token !== undefined;
    axios.defaults.headers.Authorization =
      state.isLoggedIn ? 'Bearer ' + localStorage.token : undefined;
    state.isAdmin = state.isLoggedIn && state.me && state.me.isAdmin === true;
  },
  setMe (state, me) {
    state.me = me;
    state.isAdmin = state.isLoggedIn && state.me && state.me.isAdmin === true;
  },
  setTokenExpirationTime (state, expiresIn) {
    state.tokenExpiredAt = new Date().addSeconds((expiresIn/2))
  },
  setMyNextToDo (state, toDo) {
    state.myNextToDo = toDo
  }
};

function handleLogin(commit, accessToken) {
  delete localStorage.token;
  localStorage.token = accessToken;
  commit('checkLoginStatus');
}

function handleLogout(commit) {
  delete localStorage.token;
  commit('setMe', undefined);
  commit('checkLoginStatus');
  router.go('/')
}

function handleError(error) {
  delete localStorage.token;
  if (error.response) {
    EventBus.$emit('loginError', error.response.data.error);
  } else {
    EventBus.$emit('loginError', error.message);
  }
}

Date.prototype.addSeconds = function(seconds) {
  this.setTime(this.getTime() + (seconds*1000));
  return this;
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
