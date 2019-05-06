import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
};

const getters = {};

const actions = {
  async storeAnswers ({commit, dispatch}, answers) {
    if (!Array.isArray(answers)) {
      answers = [answers]
    }
    await axios.post('answers', {answers}).catch((error) => {
      handleError('storeAnswerError', error, dispatch)
    });
  }
};

const mutations = {};

function handleError(eventName, dispatch, error) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'answers/' + eventName.split('Error')[0] }, { root: true });
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
