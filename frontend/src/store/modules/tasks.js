import axios from "../auth-axios";
import {EventBus} from "../../event-bus"

const state = {
  all: [],
  selectedTaskToEdit: null,
  emptyTask: {
    id: '',
    title: null,
    body: ''
  }
};

const getters = {
  getTask (state, id) {
    for (let i = 0; i < state.all.length; i++) {
       if (state.all[i].id === id) return state.all[i]
    }
  }
};

const actions = {
  async getAllTasks ({commit}) {
    let response = await axios.get('tasks')
      .catch((error) => {
        EventBus.$emit('getAllTasksError', error.response ? error.response.data.error : error.message);
      });
    if (response) {
      commit('setTasks', response.data);
      commit('setTaskToEdit', response.data[0])
    }
  },
  async getTaskById ({commit}, id) {
    return await axios.get('tasks/' + id)
      .catch((error) => {
        EventBus.$emit('getTaskByIdError', error.response ? error.response.data.error : error.message);
      });
  },
  async storeNewTask ({commit, dispatch}, task) {
    let response = await axios.post('tasks', task).catch((error) => {
      handleError('storeNewTaskError', error, dispatch)
    });
    if (response) {
      commit('addTask', response.data);
      commit('resetEmptyTask');
      commit('setTaskToEdit', response.data)
    }
  },
  async updateTask ({commit, dispatch}, task) {
    if (task.id === null || task.id === undefined) return;
    let response = await axios.put('tasks/' + task.id, task).catch((error) => {
      handleError('updateTaskError', error, dispatch)
    });
    if (response.data === "success") {
      commit('updateTask', task)
    }
  },
  async deleteTask ({commit, dispatch}, task) {
    if (task.id === null || task.id === undefined) return;
    let response = await axios.delete('tasks/' + task.id).catch((error) => {
      handleError('deleteTaskError', error, dispatch)
    });

    if (response.data === "success") {
      commit('removeTask', task);
      commit('setTaskToEdit', task)
    }
  },
  setTaskToEdit ({commit}, task) {
    commit('setTaskToEdit', task)
  }
};

const mutations =  {
  setTasks (state, tasks) {
    state.all = tasks
  },
  addTask (state, task) {
    state.all.push(task)
  },
  updateTask (state, task) {
    let updated = false;
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === task.id) {
        state.all[i] = task;
        updated = true;
        break
      }
    }
    if (!updated)
      state.all.push(task)
  },
  removeTask (state, task) {
    for (let i = 0; i < state.all.length; i++) {
      if (state.all[i].id === task.id) {
        state.all.splice(i, 1);
        break
      }
    }
  },
  setTaskToEdit (state, task) {
    if (task) {
      state.selectedTaskToEdit = task;
    } else if (state.all.length > 0) {
      state.selectedTaskToEdit = state.all[length-1]
    } else {
      state.selectedTaskToEdit = state.emptyTask
    }
  },
  resetEmptyTask (state) {
    state.emptyTask = {
      id: '',
      title: null,
      body: ''
    }
  }
};

function handleError(eventName, error, dispatch) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'tasks/' + eventName.split('Error')[0] }, { root: true });
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
