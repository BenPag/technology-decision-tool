<template>
  <div class="questionnaireSummary d-flex flex-wrap justify-content-between">
    <div
      v-for="(question, key) in questionnaireSummary.questions"
      :key="key"
      class="w-50 px-3 py-1">
      <h5 class="text-break">{{ question.question }}</h5>
      <table class="table table-sm table-striped table-responsive text-center">
        <thead>
          <tr>
            <th>Antwort</th>
            <th>Anzahl</th>
            <th>Prozent</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(value, key) in question.answers"
            :key="key">
            <td>{{ getDescriptionByValue(question, key) }}</td>
            <td>{{ value.count }}</td>
            <td>{{ calculatePercentage(value.count, value.maxCount) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from "vuex";

  export default {
    name: 'Summary',
    title: 'Auswertung - Fragebogen',
    props: {
      'questionnaireSummary': {
        type: Object,
        required: true,
        default: function () {
          return {
            id: 0,
            name: "Dummy QuestionnaireSummary",
            questions: [
              { name: 'Dummy Question', answers: [] }
            ] }
        }
      }
    },
    computed: {
      ...mapState({
        questions: state => state.questions.all,
      })
    },
    methods: {
      calculatePercentage(counter, maxValue) {
        return new Intl.NumberFormat('de-De', { maximumSignificantDigits: 3 }).format(counter / maxValue * 100) + '%'
      },
      getDescriptionByValue(question, value) {
        let match = this.questions.find((item) => item.question === question.question);
        if (match) {
          if (match.type === 'radio') {
            if (value == "1") {
              return 'Ja'
            } else if (value == "0") {
              return 'Nein'
            }
          }
          let option = match.options.find((item) => item.value === value);
          return option ? option.description : value
        }
        return value;
      }
    }
  }
</script>
