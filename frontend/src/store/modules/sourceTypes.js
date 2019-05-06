import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
};

const getters = {};

const actions = {
  async getAllSourceTypes ({commit, dispatch}) {
    let response = await axios.get('sourceTypes')
      .catch((error) => {
        handleError('',  dispatch, error)
      });

    if (response) {
      commit('setSourceTypes', response.data);
    }
  }
};

const mutations = {
  setSourceTypes (state, sourceTypes) {
    state.all = sourceTypes
  }
};

function handleError(eventName, dispatch, error) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'sourceTypes/' + eventName.split('Error')[0] }, { root: true });
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
