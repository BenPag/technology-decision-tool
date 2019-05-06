import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
};

const getters = {};

const actions = {
  async getSummary ({commit, dispatch}) {
    let response = await axios.get('summary').catch((error) => {
      handleError('getSummaryError', error, dispatch)
    });

    if (response) {
      commit('setSummary', response.data);
    }
  }
};

const mutations = {
  setSummary(state, summary) {
    state.all = summary;
  }
};

function handleError(eventName, dispatch, error) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'summary/' + eventName.split('Error')[0] }, { root: true });
  } else {
    let message = error.response ? error.response.data : error.message;
    EventBus.$emit(eventName, message);
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
