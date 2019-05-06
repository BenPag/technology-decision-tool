<template>
  <div id="administrationQuestionnaireOverview">
    <div class="row">
      <div class="col-5">
        <table class="table table-sm table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th
                class="text-center"
                scope="col">
                #
              </th>
              <th scope="col">Name</th>
              <th scope="col" />
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="questionnaire in questionnaires"
              :key="questionnaire.id"
              :class="{'table-primary': selectedQuestionnaireToEdit.id === questionnaire.id}"
              class="cursor-pointer"
              @click="setQuestionnaireToEdit(questionnaire)">
              <td class="text-center">{{ questionnaire.id }}</td>
              <td>{{ questionnaire.name }}</td>
              <td
                class="text-secondary text-center align-middle"
                @click="deleteQuestionnaire(questionnaire)">
                <fa icon="trash" />
              </td>
            </tr>
            <tr
              class="table-success cursor-pointer"
              @click="setQuestionnaireToEdit(emptyQuestionnaire)">
              <td class="text-center align-middle">
                <fa icon="plus" />
              </td>
              <td>Neuen Fragebogen anlegen</td>
              <td />
            </tr>
          </tbody>
        </table>
      </div>
      <div
        v-if="selectedQuestionnaireToEdit"
        class="col-7">
        <questionnaireCreator :questionnaire="selectedQuestionnaireToEdit"/>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from "vuex";
  import QuestionnaireCreator from "./Form";

  export default {
    name: 'AdministrationQuestionnaireOverview',
    title: 'Übersicht - Fragebögen',
    components: {
      QuestionnaireCreator
    },
    data () {
      return { }
    },
    computed: {
      ...mapState({
        questionnaires: state => state.questionnaires.all,
        selectedQuestionnaireToEdit: state => state.questionnaires.selectedQuestionnaireToEdit,
        emptyQuestionnaire: state => state.questionnaires.emptyQuestionnaire
      })
    },
    created () {
      this.getAllQuestionnaires();
    },
    methods: {
      ...mapActions('questionnaires', [
        'getAllQuestionnaires',
        'setQuestionnaireToEdit',
        'deleteQuestionnaire'
      ])
    }
  }
</script>
