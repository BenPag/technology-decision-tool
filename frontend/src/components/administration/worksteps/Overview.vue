<template>
  <div id="administrationWorkStepOverview">
    <div
      class="row">
      <div class="col-5">
        <table class="table table-sm table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th scope="col">Pos</th>
              <th scope="col">Name</th>
              <th scope="col">Typ</th>
            </tr>
          </thead>
          <draggable
            v-model="steps"
            group="steps"
            tag="tbody">
            <tr
              v-for="step in steps"
              :key="step.id">
              <td>{{ step.position }}</td>
              <td v-if="step.task_id > 0 && tasks.length > 0">{{ getTaskById(step.task_id).title }}</td>
              <td v-else-if="step.questionnaire_id > 0 && questionnaires.length > 0">{{ getQuestionnaireById(step.questionnaire_id).name }}</td>
              <td v-else />
              <td> {{ step.task_id > 0 ? 'Aufgabe' : 'Fragebogen' }}</td>
            </tr>
          </draggable>
        </table>
      </div>
      <div class="col-5 offset-1">
        <table class="table table-sm table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Typ</th>
            </tr>
          </thead>
          <draggable
            v-model="disassociatedSteps"
            group="steps"
            tag="tbody">
            <tr
              v-for="step in disassociatedSteps"
              :key="step.id">
              <td v-if="step.task_id > 0 && tasks.length > 0">{{ getTaskById(step.task_id).title }}</td>
              <td v-else-if="step.questionnaire_id > 0 && questionnaires.length > 0">{{ getQuestionnaireById(step.questionnaire_id).name }}</td>
              <td v-else />
              <td> {{ step.task_id > 0 ? 'Aufgabe' : 'Fragebogen' }}</td>
            </tr>
          </draggable>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <draggable v-model="questionnaires" />
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from 'vuex'
  import draggable from 'vuedraggable/src/vuedraggable'

  export default {
    name: 'AdministrationWorkStepsOverview',
    title: 'Übersicht - Arbeitsablauf',
    components: { draggable },
    data () {
      return {
        loadDisassociatedStepsTimeout: null
      }
    },
    computed: {
      ...mapState({
        questionnaires: state => state.questionnaires.all,
        tasks: state => state.tasks.all,
      }),
      steps: {
        get() {
          return this.$store.state.steps.all
        },
        set(steps) {
          this.reorderSteps(steps);
        }
      },
      disassociatedSteps: {
        get() {
          return this.$store.state.steps.disassociatedSteps
        },
        set(steps) {
          console.log(steps);
        }
      }
    },
    created () {
      this.getAllSteps();
      this.getAllQuestionnaires();
      this.loadDisassociatedStepsTimeout = setTimeout(function () {
        this.setDisassociatedSteps();
      }.bind(this), 1000)
    },
    methods: {
      ...mapActions('steps', [
        'getAllSteps',
        'reorderSteps',
        'deleteStep'
      ]),
      ...mapActions('questionnaires', [
        'getAllQuestionnaires',
      ]),
      getTaskById(id) {
        let match = this.tasks.find(value => value.id === id);
        if (!match) {
          return {
            name: 'no match'
          }
        }
        return match
      },
      getQuestionnaireById(id) {
        let match = this.questionnaires.find(value => value.id === id);
        if (!match) {
          return {
            name: 'no match'
          }
        }
        return match
      },
      getNonAssociatedTasks() {
        let keys = [];
        for (let i = 0; i < this.tasks.length; i++) {
          if (this.steps.find(value => value.task_id > 0 && value.task_id === this.tasks[i].id)) {
            keys.push(i);
          }
        }
        return this.tasks.filter((value, key) => !keys.includes(key));
      },
      getNonAssociatedQuestionnaires() {
        let keys = [];
        for (let i = 0; i < this.questionnaires.length; i++) {
          if (this.steps.find(value => value.questionnaire_id > 0 && value.questionnaire_id === this.questionnaires[i].id )) {
            keys.push(i);
          }
        }
        return this.questionnaires.filter((value, key) => !keys.includes(key));
      },
      setDisassociatedSteps() {
        if (this.disassociatedSteps.length > 0 || this.tasks.length > 0 || this.questionnaires.length > 0) {
          clearTimeout(this.loadDisassociatedStepsTimeout);
        }

        let tasks = this.getNonAssociatedTasks();
        let questionnaires = this.getNonAssociatedQuestionnaires();
        let disassociatedSteps = [];

        for (let i = 0; i < tasks.length; i++) {
          disassociatedSteps.push({
            id: null,
            position: null,
            task_id: tasks[i].id,
            questionnaire_id: 0,
          })
        }
        for (let i = 0; i < questionnaires.length; i++) {
          disassociatedSteps.push({
            id: null,
            position: null,
            task_id: 0,
            questionnaire_id: questionnaires[i].id,
          })
        }
        this.$store.commit('steps/setDisassociatedSteps', disassociatedSteps);
      }
    }
  }
</script>
