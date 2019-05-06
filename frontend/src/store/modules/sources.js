import axios from "../auth-axios";
import {EventBus} from "../../event-bus";

const state = {
  all: [],
};

const getters = {};

const actions = {
  async getAllSources ({commit, dispatch, rootState}) {
    await getSubjects(rootState);
    await getSourceTypes(rootState);
    let response = await axios.get('sources').catch((error) => {
      handleError('getAllSourcesError', error, dispatch);
    });

    if (response) {
      commit('setSources', formatData(response.data, rootState))
    }
  },
  async storeNewSource ({commit, dispatch, rootState}, source) {
    if (!rootState.auth.me) {
      await dispatch('auth/getMe', null, {root: true});
    }
    source.stepId = rootState.auth.me.progress;
    let response = await axios.post('sources', source).catch((error) => {
      handleError('storeNewSourceError', error, dispatch)
    });
    if (response) {
      commit('addSources', formatData(response.data, rootState))
    }
  }
};

const mutations = {
  setSources (state, sources) {
    state.all = sources;
  },
  addSources (state, sources) {
    for (let i = 0; i < sources.length; i++)
      state.all.push(sources[i])
  }
};

async function getSubjects(rootState) {
  let subjects = rootState.subjects.all;
  if (subjects === null || subjects.length < 0) {
    await rootState.dispatch('subjects/getAllSubjects');
  }
}

async function getSourceTypes(rootState) {
  let sourceTypes = rootState.sourceTypes.all;
  if (sourceTypes === null || sourceTypes.length < 0) {
    await rootState.dispatch('sourceTypes/getAllSourceTypes');
  }
}

function formatData(data, rootState) {
  let subjects = rootState.subjects.all;
  let sourceTypes = rootState.sourceTypes.all;

  if (!Array.isArray(data))
    data = [data];

  for (let i = 0; i < data.length; i++) {
    data[i].subject = subjects.find(subject => { return subject.id === data[i].subject_id });
    data[i].sourceType = sourceTypes.find(sourceType => { return sourceType.id === data[i].source_type_id });
  }

  return data;
}

function handleError(eventName, error, dispatch) {
  if (error.response && error.response.status === 401) {
    dispatch('auth/refresh', { uri: 'sources/' + eventName.split('Error')[0] }, { root: true });
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
