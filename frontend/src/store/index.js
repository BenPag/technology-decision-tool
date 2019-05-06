import Vue from 'vue'
import Vuex from "vuex"
import answers from "./modules/answers";
import auth from "./modules/auth";
import questionnaires from "./modules/questionnaires";
import questions from "./modules/questions";
import sources from "./modules/sources";
import sourceTypes from "./modules/sourceTypes";
import subjects from "./modules/subjects";
import summary from "./modules/summary";
import tasks from "./modules/tasks";
import steps from "./modules/workSteps";

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    answers,
    auth,
    questionnaires,
    questions,
    sources,
    sourceTypes,
    subjects,
    summary,
    tasks,
    steps
  },
  strict: debug,
})