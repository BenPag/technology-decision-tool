import axios from "../auth-axios";
import {EventBus} from "../../event-bus"
import Vue from 'vue'

const state = {
  all: [],
  questions: [],
  selectedQuestionnaireToEdit: null,
  emptyQuestionnaire: {
    id: 999999,
    name: null,
  }
};

const getters = {
  getQuestionnaireQuestionsById: (state) => (id) => {
    let questions = state.questions.find((value, key) => key === id);
    return questions ? questions : []
  }
};

const actions = {
  async getAllQuestionnaires ({commit, dispatch}) {
    let response = await axios.get('questionnaires')
      .catch((error) => {
        handleError('getAllQuestionnairesError',  dispatch, error)
      });

    if (response) {
      commit('setQuestionnaires', response.data);
      commit('setQuestionnaireToEdit', response.data[0]);
    }
  },
  async getQuestionnaire ({commit, dispatch}, id) {
    return await axios.get('questionnaires/' + id)
      .catch((error) => {
        handleError('getAllQuestionnairesError',  dispatch, error)
      });
  },
  async getQuestionnaireQuestions ({commit, dispatch}, id) {
    if (id === null || id === undefined || id === 999999) return;
    let response = await axios.get('questionnaires/' + id  + '/questions')
      .catch((error) => {
        handleError('getAllQuestionnairesError',  dispatch, error)
      });

    if (response) {
      commit('setQuestionnaireQuestions', {"data": response.data, "questionnaireId" : id});
    }
  },
  async storeNewQuestionnaire ({commit, dispatch}, questionnaire) {
    questionnaire.id = null;
    let response = await axios.post('questionnaires', questionnaire).catch((error) => {
      handleError('storeNewQuestionnaireError', error, dispatch)
    });
    if (response) {
      await dispatch('updateQuestionnaireQuestions', response.data.id);
      commit('addQuestionnaire', response.data);
      commit('resetEmptyQuestionnaire');
      commit('setQuestionnaireToEdit', response.data)
    }
  },
  async updateQuestionnaire ({commit, dispatch}, questionnaire) {
    if (questionnaire.id === null || questionnaire.id === undefined || questionnaire.id === 999999) return;
    let response = await axios.put('questionnaires/' + questionnaire.id, questionnaire).catch((error) => {
      handleError('updateQuestionnaireError', error, dispatch)
    });
    if (response.data === "success") {
      commit('updateQuestionnaire', questionnaire)
    }
  },
  async deleteQuestionnaire ({commit, dispatch}, questionnaire) {
    if (questionnaire.id === null || questionnaire.id === undefined || questionnaire.id === 999999) return;
    let response = await axios.delete('questionnaires/' + questionnaire.id).catch((error) => {
      handleError('deleteQuestionnaireError', error, dispatch)
    });

    if (response.data === "success") {
      commit('removeQuestionnaire', questionnaire);
      commit('setQuestionnaireToEdit')
    }
  },
  async updateQuestionnaireQuestions ({commit, getters, dispatch}, id) {
    if (id === null || id === undefined || id === 999999) return;
    let questions = getters.getQuestionnaireQuestionsById(id);
    let response = await axios.post('questionnaires/' + id + '/questions', {questions}).catch((error) => {
      handleError('updateQuestionnaireQuestionsError', error, dispatch)
    });
    if (response.data !== "success") {
      // toDo
    }
  },
  setQuestionnaireToEdit ({commit}, questionnaire) {
    commit('setQuestionnaireToEdit', questionnaire)
  }
};

const mutations = {
  setQuestionnaires (state, questionnaires) {
    state.all = questionnaires
  },
  addQuestionnaire (state, payload) {
    state.all[payload.key] = payload.data
  },
  setQuestionnaireQuestions (state, payload) {
    if (state.questions[payload.questionnaireId]) {
      Vue.delete(state.questions, payload.questionnaireId)
    }
    Vue.set(state.questions, payload.questionnaireId, payload.data)

  },
  addQuestionnaireQuestions (state, payload) {
    if (state.questions[payload.questionnaireId]) {
      let questions = state.questions[payload.questionnaireId].slice(0).flat();
      if (Array.isArray(payload.data)) {
        for (let i = 0; i < payload.data.length; i++) {
          questions.push(payload.data[i])
        }
      } else {
        questions.push(payload.data)
      }
      Vue.delete(state.questions, payload.questionnaireId);
      Vue.set(state.questions, payload.questionnaireId, questions);
    } else {
      Vue.set(state.questions, payload.questionnaireId, payload.data);
    }
  },
  removeQuestionnaireQuestion (state, payload) {
    let questions = state.questions[payload.questionnaireId].slice(0).flat();
    questions.splice(questions.findIndex(value => value.id === payload.data.id), 1);

    Vue.delete(state.questions, payload.questionnaireId);
    Vue.set(state.questions, payload.questionnaireId, questions);
  },
  setQuestionnaireToEdit (state, questionnaire) {
    if (questionnaire) {
      state.selectedQuestionnaireToEdit = questionnaire
    } else if (state.all.length > 0) {
      state.selectedQuestionnaireToEdit = state.all[length-1]
    } else {
      state.selectedQuestionnaireToEdit = state.emptyQuestionnaire
    }
  },
  updateQuestionnaire (state, questionnaire) {
    let updated = false;
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === questionnaire.id) {
        state.all[i] = questionnaire;
        updated = true;
        break
      }
    }
    if (!updated)
      state.all.push(questionnaire)
  },
  removeQuestionnaire (state, questionnaire) {
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === questionnaire.id) {
        state.all.splice(i, 1);
        break
      }
    }
  },
  resetEmptyQuestionnaire (state) {
    state.emptyQuestionnaire = {
      id: 999999,
      name: null,
    }
  }
};

function handleError(eventName, dispatch, error) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'questionnaires/' + eventName.split('Error')[0] }, { root: true });
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
