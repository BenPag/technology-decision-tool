<template>
  <div id="summaryOverview">
    <h1 class="mb-3">Übersicht - Auswertung</h1>
    <div
      v-for="(questionnaireSummary, key) in summary"
      :key="key"
      class="card">
      <div
        :id="'questionnaireSummaryHeading_' + key"
        class="card-header" >
        <h5 class="mb-0">
          <button
            :aria-controls="'collapseQuestionnaireSummary_' + key"
            :data-target="'#collapseQuestionnaireSummary_' + key"
            class="btn btn-pico-inverse collapsed"
            type="button"
            data-toggle="collapse"
            aria-expanded="false">
            {{ questionnaireSummary.name }}
          </button>
        </h5>
      </div>
      <div
        :id="'collapseQuestionnaireSummary_' + key"
        :aria-labelledby="'questionnaireSummaryHeading_' + key"
        class="collapse"
        data-parent="#summaryOverview">
        <div class="card-body">
          <questionnaireSummary :questionnaire-summary="questionnaireSummary"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from "vuex";
  import QuestionnaireSummary from "./QuestionnaireSummary";

  export default {
    name: 'Summary',
    title: 'Übersicht - Auswertung',
    components: {
      QuestionnaireSummary
    },
    computed: {
      ...mapState({
        summary: state => state.summary.all,
        questions: state => state.questions.all,
      })
    },
    created () {
      this.getSummary();
      this.getAllQuestions();
    },
    methods: {
      ...mapActions('summary', [
        'getSummary',
      ]),
      ...mapActions('questions', [
        'getAllQuestions',
      ])
    }
  }
</script>
