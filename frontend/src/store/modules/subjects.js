import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: []
};

const getters = {};

const actions = {
  async getAllSubjects ({commit}) {
    let response = await axios.get('subjects')
      .catch((error) => {
        if (error.response) {
          EventBus.$emit('getAllSubjectsError', error.response.data.error);
        } else {
          EventBus.$emit('getAllSubjectsError', error.message);
        }
      });
    if (response) {
      commit('setSubjects', response.data);
    }
  },
};

const mutations =  {
  setSubjects (state, subjects) {
    state.all = subjects
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
