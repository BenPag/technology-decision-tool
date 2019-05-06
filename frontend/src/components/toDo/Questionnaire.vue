<template>
  <div
    class="questionaire">
    <h2 v-if="questionnaire">Fragebogen: {{ questionnaire.name }}</h2>
    <div
      v-if="errors.length"
      class="alert alert-danger">
      <b>Bitte korrigieren Sie den/die folgenden Fehler:</b>
      <ul>
        <li
          v-for="(error, key) in errors"
          :key="key">
          {{ error }}
        </li>
      </ul>
    </div>
    <form
      v-if="questions"
      @submit.prevent
      @submit="submit()">
      <div
        class="form-row">
        <div
          v-for="question in questions"
          :key="question.id"
          :class="{'col-auto': question.type !== 'textarea', 'col-6': question.type === 'textarea'}"
          class="form-group py-2 px-3">
          <h5 v-html="formatQuestion(question.question)" />
          <div v-if="question.type === 'select'">
            <label
              :for="question.id"
              class="d-none">
              {{ question.description }}
            </label>
            <select
              :name="question.id"
              :id="question.id"
              :required="question.required === 1"
              v-model="question.selection"
              class="form-control">
              <option
                v-for="option in question.options"
                :key="option.key"
                :value="option.value">
                {{ option.description }}
              </option>
            </select>
          </div>
          <div v-if="question.type === 'text'">
            <label
              :for="question.id"
              class="d-none">
              {{ question.description }}
            </label>
            <input
              :name="question.id"
              :required="question.required === 1"
              v-model="question.selection"
              type="text">
          </div>
          <div v-if="question.type === 'textarea'">
            <label
              :for="question.id"
              class="d-none">
              {{ question.description }}
            </label>
            <textarea
              :name="question.id"
              :required="question.required === 1"
              v-model="question.selection"
              class="form-control"
              rows="5" />
          </div>
          <div v-if="question.type === 'number'">
            <label
              :for="question.id"
              class="d-none">
              {{ question.description }}
            </label>
            <input
              v-model="question.selection"
              :name="question.id"
              :required="question.required === 1"
              type="number"
              class="form-control">
          </div>
          <table
            v-if="question.type === 'checkbox'"
            class="table table-responsive table-striped">
            <tr
              v-for="option in question.options"
              :key="option.key">
              <label
                :for="question.id+'[]'"
                class="form-check-label"
              >
                {{ option.description }}
              </label>
              <input
                :name="question.id+'[]'"
                :required="question.required === 1"
                v-model="question.selection"
                type="checkbox"
                class="form-check-input">
            </tr>
          </table>
          <table
            v-if="question.type === 'radio'"
            class="table table-bordered table-striped text-center">
            <tr>
              <td
                v-for="option in question.options"
                :key="option.key">
                <label
                  :for="question.id"
                  class="form-check-label">
                  {{ option.description }}
                </label>
              </td>
            </tr>
            <tr>
              <td
                v-for="option in question.options"
                :key="option.key">
                <input
                  :name="question.id"
                  :value="option.value"
                  :required="question.required === 1"
                  v-model="question.selection"
                  type="radio"
                  class="form-check-input">
              </td>
            </tr>
          </table>
        </div>
      </div>
      <button
        type="submit"
        class="btn btn-pico-inverse float-right">
        Absenden
      </button>
    </form>
  </div>
</template>

<script>
  import {mapActions, mapState} from 'vuex'

  export default {
    name: 'Questionnaire',
    props: {
      'questionnaire': {
        type: Object,
        required: true,
        default: function () {
          return { id: 0, name: 'Dummy questionnaire' }
        }
      }
    },
    data() {
      return {
        errors: [],
        loadingTimeout: null
      }
    },
    computed: {
      ...mapState({
        questions (state) {
          return state.questionnaires.questions[this.questionnaire.id]
        }
      }),
    },
    created() {
      this.loadingTimeout = setTimeout(function () {
        this.getQuestionnaireQuestions(this.questionnaire.id);
        if (this.questions > 0)
          clearTimeout(this.loadingTimeout)
      }.bind(this), 1500)
    },
    methods: {
      ...mapActions('questionnaires', [
        'getQuestionnaireQuestions'
      ]),
      ...mapActions('answers', [
        'storeAnswers'
      ]),
      ...mapActions('auth', [
        'finishStep'
      ]),
      submit() {
        let answers = [];
        this.errors = [];
        for (let i=0; i < this.questions.length; i++) {
          if (!this.questions[i].selection) {
            this.errors.push(this.questions[i].question + " ist ein Pflichtfeld");
          }
          answers.push({
            "questionId": this.questions[i].id,
            "questionnaireId": this.questionnaire.id,
            "value": this.questions[i].selection
          })
        }
        if (this.errors.length === 0) {
          this.storeAnswers(answers);
          this.finishStep()
        }
      },
      formatQuestion (question) {
        let count = 0;
        return question.replace(/\s+/g, match => !(++count % 7) ? `${match}</br>` : match);
      }
    }
  }
</script>
