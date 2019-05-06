<template>
  <div class="form-row">
    <div class="col-12 mb-4">
      <label for="questionnaire">
        <strong v-if="questionnaire.id">Fragebogen bearbeiten</strong>
        <strong v-else>Fragebogen erstellen</strong>
      </label>
      <input
        id="questionnaire"
        v-model="questionnaire.name"
        type="text"
        placeholder="Name des Fragebogens eingeben"
        class="form-control"
        @blur="updateQuestionnaire(questionnaire)">
    </div>
    <div class="col-12 mb-4">
      <button
        class="btn btn-success w-100"
        type="button"
        data-toggle="modal"
        data-target="#addQuestionsToQuestionnaireModal">
        Weitere Fragen hinzufügen
      </button>
    </div>
    <div class="col-12 mb-3">
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Frage</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="question in questionnaireQuestions"
            :key="question.id"
            @blur="updateQuestionnaire(questionnaire)">
            <td>
              {{ question.id }}
            </td>
            <td>
              {{ question.question }}
            </td>
            <td class="text-center align-middle">
              <button
                class="btn btn-sm btn-danger py-0 align-middle"
                @click="removeQuestion(question)">
                <fa icon="trash" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div
      v-if="!questionnaire.id"
      class="col-3 offset-9">
      <button
        class="btn btn-sm btn-success"
        @click="storeNewQuestionnaire(questionnaire)">
        Fragebogen hinzufügen
      </button>
    </div>
    <div
      id="addQuestionsToQuestionnaireModal"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addQuestionsToQuestionnaireLabel"
      aria-hidden="true">
      <div
        class="modal-dialog modal-lg modal-dialog-centered"
        role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              id="addQuestionsToQuestionnaireLabel"
              class="modal-title">Weitere Fragen hinzufügen</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-sm table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Frage</th>
                  <th
                    scope="col"
                    class="text-center">
                    <fa icon="plus" />
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="question in notAssignedQuestions"
                  :key="question.id"
                  class="cursor-pointer">
                  <td>{{ question.id }}</td>
                  <td>{{ question.question }}</td>
                  <td class="text-center align-middle">
                    <div class="custom-control custom-checkbox">
                      <input
                        :id="'question-' + question.id"
                        :value="question"
                        v-model="selectedQuestions"
                        type="checkbox"
                        class="custom-control-input">
                      <label
                        :for="'question-' + question.id"
                        class="custom-control-label" />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-danger mr-auto"
              data-dismiss="modal">
              Abbrechen
            </button>
            <button
              type="button"
              class="btn btn-pico-inverse"
              data-dismiss="modal"
              @click="addQuestions()">
              Fragen hinzufügen
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters, mapState} from 'vuex';

  export default {
    name: 'QuestionnaireForm',
    props: {
      'questionnaire': {
        type: Object,
        required: true,
        default: function () {
          return { id: 0, name: "Dummy Questionnaire" }
        }
      }
    },
    data () {
      return {
        selectedQuestions: []
      }
    },
    computed: {
      ...mapState({
        questions: state => state.questions.all
      }),
      ...mapGetters('questionnaires', [
        'getQuestionnaireQuestionsById'
      ]),
      questionnaireQuestions () {
        return this.getQuestionnaireQuestionsById(this.questionnaire.id)
      },
      notAssignedQuestions () {
        let keys = [];
        for (let i = 0; i < this.questions.length; i++) {
          if (this.questionnaireQuestions.find(value => value.id === this.questions[i].id )) {
            keys.push(i);
          }
        }
        return this.questions.filter((value, key) => !keys.includes(key));
      }
    },
    created () {
      if (!this.questions) {
        this.$store.dispatch('questions/getAllQuestions')
      }
      if (this.questionnaireQuestions.length < 1) {
        this.getQuestionnaireQuestions(this.questionnaire.id);
      }
    },
    beforeUpdate () {
      if (this.questionnaireQuestions.length < 1) {
        this.getQuestionnaireQuestions(this.questionnaire.id);
      }
    },
    methods: {
      ...mapActions('questionnaires', [
        'getQuestionnaireQuestions',
        'storeNewQuestionnaire',
        'updateQuestionnaire',
        'updateQuestionnaireQuestions'
      ]),
      addQuestions () {
        this.$store.commit('questionnaires/addQuestionnaireQuestions', {
          questionnaireId: this.questionnaire.id,
          data: this.selectedQuestions
        });
        this.updateQuestionnaireQuestions(this.questionnaire.id)
      },
      removeQuestion (question) {
        this.$store.commit('questionnaires/removeQuestionnaireQuestion', {
          questionnaireId: this.questionnaire.id,
          data: question
        });
        this.updateQuestionnaireQuestions(this.questionnaire.id)
      }
    }
  }
</script>
