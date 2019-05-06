import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
  disassociatedSteps: [],
  selectedStepToEdit: null,
  emptyStep: {
    id: null,
    position: null,
  },
  maxSteps: 0
};

const getters = {
  getStepsCount: (state) => {
    return state.maxSteps
  }
};

const actions = {
  async getAllSteps ({commit}) {
    let response = await axios.get('steps')
      .catch((error) => {
        EventBus.$emit('getAllStepsError', error.response ? error.response.data.error : error.message);
      });
    if (response) {
      commit('setSteps', response.data);
      commit('setStepsCount', response.data);
      commit('setStepToEdit', response.data[0])
    }
  },
  async getNextToDoByStepId ({commit}, id) {
    let response = await axios.get('steps/' + id)
      .catch((error) => {
        EventBus.$emit('getStepByIdError', error.response ? error.response.data.error : error.message);
      });
    if (response) {
      //commit('updateSteps', response.data);
    }
  },
  async storeNewStep ({commit, dispatch}, step) {
    let response = await axios.post('steps', step).catch((error) => {
      handleError('storeNewStepError', error, dispatch)
    });
    if (response) {
      commit('addStep', response.data);
      commit('resetEmptyStep');
      commit('setStepToEdit', response.data)
    }
  },
  async reorderSteps({commit, dispatch, state}, steps) {
    let addedSteps = [];
    console.log("reorderSteps", steps);
    for (let i = 0; i < steps.length;) {
      if (steps[i].id == null || steps[i].id === undefined) {
        steps[i].position = ++i;
        addedSteps.push(steps[i])
      } else {
        commit('updateStepPosition', { step: steps[i], position: ++i });
      }
    }
    console.log("addedSteps", addedSteps);
    commit('sortStepsByPosition');

    for (let i = 0; i < addedSteps.length;) {
      await dispatch('storeNewStep', addedSteps[i]);
    }
    await axios.put('steps', { steps : state.all }).catch((error) => {
      handleError('reorderStepsError', error, dispatch)
    });

    commit('setStepsCount');
    commit('sortStepsByPosition');
  },
  async updateStep ({commit, dispatch}, step) {
    if (step.id === null || step.id === undefined) return;
    let response = await axios.put('steps/' + step.id, step).catch((error) => {
      handleError('updateStepError', error, dispatch)
    });
    if (response.data === "success") {
      commit('updateStep', step)
    }
  },
  async deleteStep ({commit, dispatch}, step) {
    if (step.id === null || step.id === undefined) return;
    let response = await axios.delete('steps/' + step.id).catch((error) => {
      handleError('deleteStepError', error, dispatch)
    });

    if (response.data === "success") {
      commit('removeStep', step);
      commit('setStepToEdit', step)
    }
  },
  setStepToEdit ({commit}, task) {
    commit('setStepToEdit', task)
  }
};

const mutations =  {
  setSteps (state, steps) {
    state.all = steps
  },
  setDisassociatedSteps (state, disassociatedSteps) {
    state.disassociatedSteps = disassociatedSteps
  },
  addStep (state, step) {
    state.all.push(step)
  },
  updateStep (state, step) {
    let updated = false;
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === step.id) {
        state.all[i] = step;
        updated = true;
        break
      }
    }
    if (!updated)
      state.all.push(step)
  },
  updateStepPosition (state, payload) {
    let updated = false;
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === payload.step.id) {
        state.all[i].position = payload.position;
        updated = true;
        break
      }
    }
  },
  removeStep (state, step) {
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === step.id) {
        state.all.splice(i, 1);
        break
      }
    }
  },
  setStepToEdit (state, step) {
    if (step) {
      state.selectedStepToEdit = step;
    } else if (state.all.length > 0) {
      state.selectedStepToEdit = state.all[length-1]
    } else {
      state.selectedStepToEdit = state.emptyStep
    }
  },
  resetEmptyStep (state) {
    state.emptyStep = {
      id: '',
      title: null,
      body: ''
    }
  },
  setStepsCount (state, steps) {
    if (steps) {
      state.maxSteps = steps.length
    } else {
      state.maxSteps = state.all.length
    }
  },
  sortStepsByPosition (state) {
    state.all.sort((a, b) => {
      return a.position - b.position;
    });
  },
};

function handleError(eventName, error, dispatch) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'steps/' + eventName.split('Error')[0] }, { root: true });
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
