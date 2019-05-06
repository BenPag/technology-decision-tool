<template>
  <div class="form-row">
    <div class="col-12 mb-4">
      <label for="question">
        <strong>Frage bearbeiten</strong>
      </label>
      <textarea
        id="question"
        v-model="question.question"
        placeholder="Frage eingeben"
        class="form-control"
        @blur="updateQuestion(question)" />
    </div>
    <div class="col-12 mb-4">
      <div class="custom-control custom-checkbox">
        <input
          id="required"
          v-model="question.required"
          true-value="1"
          false-value="0"
          type="checkbox"
          class="custom-control-input"
          @blur="updateQuestion(question)">
        <label
          class="custom-control-label"
          for="required">
          Frage ist verpflichtend
        </label>
      </div>
    </div>
    <div class="col-12 mb-4">
      <label for="questionTypeSelection">
        <strong>Art der Frage / Art des Eingabefelds</strong>
      </label>
      <select
        id="questionTypeSelection"
        v-model="question.type"
        class="form-control"
        @blur="updateQuestion(question)">
        <option
          v-for="types in questionTypes"
          :key="types.id"
          :value="types.name"
          class="text-capitalize">
          {{ types.name }}
        </option>
      </select>
    </div>
    <div
      v-if="!['text', 'textarea', 'number'].includes(question.type)"
      class="col-12 mb-3">
      <label for="questionTypeSelection">
        <strong>Verfügbare Optionen</strong>
      </label>
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Anzeigename</th>
            <th>Übermittelnder Wert</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(option, key) in question.options"
            :key="key"
            @blur="updateQuestion(question)">
            <td>
              <input
                v-model="option.description"
                type="text"
                class="form-control form-control-sm">
            </td>
            <td>
              <input
                v-model="option.value"
                type="text"
                class="form-control form-control-sm">
            </td>
            <td class="text-center align-middle">
              <button
                class="btn btn-sm btn-danger"
                @click="removeOption(key)">
                <fa icon="trash" />
              </button>
            </td>
          </tr>
          <tr>
            <td>
              <input
                v-model="addNewDescription"
                type="text"
                placeholder="Anzeigename eingeben"
                class="form-control form-control-sm bg-success-light"
                @blur="addNewOption()">
            </td>
            <td>
              <input
                v-model="addNewValue"
                type="text"
                placeholder="Wert eingeben"
                class="form-control form-control-sm bg-success-light"
                @blur="addNewOption()">
            </td>
            <td />
          </tr>
        </tbody>
      </table>
    </div>
    <div
      v-if="!question.id"
      class="col-3 offset-9">
      <button
        class="btn btn-sm btn-success"
        @click="storeNewQuestion(question)">
        Frage hinzufügen
      </button>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from 'vuex';

  export default {
    name: 'QuestionForm',
    props: {
      'question': {
        type: Object,
        required: true,
        default: function () {
          return { id: 0, question: "Dummy Question" }
        }
      }
    },
    data () {
      return {
        addedOptions: [],
        addNewDescription: null,
        addNewValue: null,
      }
    },
    computed: mapState({
      questionTypes: state => state.questions.types
    }),
    methods: {
      ...mapActions('questions', [
        'storeNewQuestion',
        'updateQuestion'
      ]),
      addNewOption() {
        if (this.addNewDescription && this.addNewValue) {
          this.question.options.push({
            description: this.addNewDescription,
            value: this.addNewValue,
          });
          this.updateQuestion(this.question);
          this.addNewDescription = null;
          this.addNewValue = null
        }
      },
      removeOption(key) {
        this.question.options.splice(key, 1);
        this.updateQuestion(this.question)
      }
    }
  }
</script>
