<template>
  <div
    v-if="nextToDo"
    class="todo container-fluid">
    <div class="row">
      <div
        v-if="nextToDo.type === 'questionnaire'"
        class="col-12">
        <questionnaire :questionnaire="nextToDo.object" />
      </div>
      <div
        v-if="nextToDo.type === 'task'"
        class="col-10 offset-1">
        <task :task="nextToDo.object"/>
      </div>
      <div
        v-if="nextToDo.type === 'task' && checkFinish()"
        class="col-3 offset-9 mt-4">
        <button
          class="btn btn-pico-inverse"
          @click="finishStep">
          Arbeitsschritt abschließen
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  import Questionnaire from "./Questionnaire";
  import Task from "./Task";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: 'Aufgaben',
    components: {
      Questionnaire,
      Task
    },
    computed: {
      ...mapGetters('auth', {
        me: 'getMe',
        nextToDo: 'getMyNextToDo',
      }),
      ...mapGetters('steps', {
        maxSteps: 'getStepsCount',
      }),
    },
    methods: {
      ...mapActions('auth', [
        'finishStep'
      ]),
      checkFinish() {
        return this.me.progress < this.maxSteps
      }
    }
  }
</script>
