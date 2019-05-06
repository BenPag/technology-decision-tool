import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
  selectedQuestionToEdit: null,
  types: [
    { id: 0, name: 'text' },
    { id: 1, name: 'textarea' },
    { id: 2, name: 'checkbox' },
    { id: 3, name: 'number' },
    { id: 4, name: 'radio' },
    { id: 5, name: 'select' },
    { id: 6, name: 'multi-select'}
  ],
  emptyQuestion: {
    id: null,
    type: 'text',
    question: null,
    options: [],
    required: 0,
  }
};

const getters = {};

const actions = {
  async getAllQuestions ({commit, dispatch}) {
    let response = await axios.get('questions')
      .catch((error) => {
        handleError('getAllQuestionsError',  dispatch, error)
      });

    if (response) {
      commit('setQuestions', response.data);
      commit('setQuestionToEdit', response.data[0]);
    }
  },
  async storeNewQuestion ({commit, dispatch}, question) {
    let response = await axios.post('questions', question).catch((error) => {
      handleError('storeNewQuestionError', error, dispatch)
    });
    if (response) {
      commit('addQuestion', response.data);
      commit('resetEmptyQuestion');
      commit('setQuestionToEdit', response.data)
    }
  },
  async updateQuestion ({commit, dispatch}, question) {
    if (question.id === null || question.id === undefined) return;
    let response = await axios.put('questions/' + question.id, question).catch((error) => {
      handleError('updateQuestionError', error, dispatch)
    });
    if (response.data === "success") {
      commit('updateQuestion', question)
    }
  },
  async deleteQuestion ({commit, dispatch}, question) {
    if (question.id === null || question.id === undefined) return;
    let response = await axios.delete('questions/' + question.id).catch((error) => {
      handleError('deleteQuestionError', error, dispatch)
    });

    if (response.data === "success") {
      commit('removeQuestion', question);
      commit('setQuestionToEdit')
    }
  },
  setQuestionToEdit ({commit}, question) {
    commit('setQuestionToEdit', question)
  }
};

const mutations = {
  setQuestions (state, questions) {
    state.all = questions
  },
  addQuestion (state, question) {
    state.all.push(question)
  },
  setQuestionToEdit (state, question) {
    if (question) {
      state.selectedQuestionToEdit = question
    } else if (state.all.length > 0) {
      state.selectedQuestionToEdit = state.all[length-1]
    } else {
      state.selectedQuestionToEdit = state.emptyQuestion
    }
  },
  updateQuestion (state, question) {
    let updated = false;
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === question.id) {
        state.all[i] = question;
        updated = true;
        break
      }
    }
    if (!updated)
      state.all.push(question)
  },
  removeQuestion (state, question) {
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === question.id) {
        state.all.splice(i, 1);
        break
      }
    }
  },
  resetEmptyQuestion (state) {
    state.emptyQuestion = {
      id: null,
      type: 'text',
      question: null,
      options: [],
      required: 0,
    }
  }
};

function handleError(eventName, dispatch, error) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'questions/' + eventName.split('Error')[0] }, { root: true });
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
