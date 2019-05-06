<template>
  <div
    id="administration"
    class="administration accordion">
    <h1 class="mb-3">Administration - Programmverwaltung</h1>
    <div class="card">
      <div
        id="taskOverviewHeading"
        class="card-header" >
        <h5 class="mb-0">
          <button
            class="btn btn-pico-inverse collapsed"
            type="button"
            data-toggle="collapse"
            data-target="#collapseTaskOverview"
            aria-expanded="false"
            aria-controls="collapseTaskOverview">
            {{ taskOverviewTitle }}
          </button>
        </h5>
      </div>
      <div
        id="collapseTaskOverview"
        class="collapse"
        aria-labelledby="taskOverviewHeading"
        data-parent="#administration">
        <div class="card-body">
          <taskOverview />
        </div>
      </div>
    </div>
    <div class="card">
      <div
        id="questionOverviewHeading"
        class="card-header">
        <h5 class="mb-0">
          <button
            class="btn btn-pico-inverse collapsed"
            type="button"
            data-toggle="collapse"
            data-target="#collapseQuestionOverview"
            aria-expanded="false"
            aria-controls="collapseQuestionOverview">
            {{ questionOverviewTitle }}
          </button>
        </h5>
      </div>
      <div
        id="collapseQuestionOverview"
        class="collapse"
        aria-labelledby="questionOverviewHeading"
        data-parent="#administration">
        <div class="card-body">
          <questionOverview />
        </div>
      </div>
    </div>
    <div class="card">
      <div
        id="questionnaireOverviewHeading"
        class="card-header">
        <h5 class="mb-0">
          <button
            class="btn btn-pico-inverse collapsed"
            type="button"
            data-toggle="collapse"
            data-target="#collapseQuestionnaireOverview"
            aria-expanded="false"
            aria-controls="collapseQuestionnaireOverview">
            {{ questionnaireOverviewTitle }}
          </button>
        </h5>
      </div>
      <div
        id="collapseQuestionnaireOverview"
        class="collapse"
        aria-labelledby="questionnaireOverviewHeading"
        data-parent="#administration">
        <div class="card-body">
          <questionnaireOverview />
        </div>
      </div>
    </div>
    <div class="card">
      <div
        id="workStepsOverviewHeading"
        class="card-header">
        <h5 class="mb-0">
          <button
            class="btn btn-pico-inverse collapsed"
            type="button"
            data-toggle="collapse"
            data-target="#collapseWorkStepsOverview"
            aria-expanded="false"
            aria-controls="collapseWorkStepsOverview">
            {{ workStepOverviewTitle }}
          </button>
        </h5>
      </div>
      <div
        id="collapseWorkStepsOverview"
        class="collapse"
        aria-labelledby="workStepsOverviewHeading"
        data-parent="#administration">
        <div class="card-body">
          <workStepOverview />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import TaskOverview from "./tasks/Overview";
  import QuestionOverview from "./questions/Overview";
  import QuestionnaireOverview from "./questionnaires/Overview";
  import WorkStepOverview from "./worksteps/Overview";
  import { library } from '@fortawesome/fontawesome-svg-core'
  import { faTrash, faPlus } from '@fortawesome/free-solid-svg-icons'
  import $ from 'jquery'

  library.add(faTrash, faPlus);

  export default {
    name: 'Administration',
    components: {
      TaskOverview,
      QuestionOverview,
      QuestionnaireOverview,
      WorkStepOverview
    },
    data () {
      return {
        taskOverviewTitle: TaskOverview.title,
        questionOverviewTitle: QuestionOverview.title,
        questionnaireOverviewTitle: QuestionnaireOverview.title,
        workStepOverviewTitle: WorkStepOverview.title
      }
    },
    mounted () {
      $('.collapsed').on('click', '#administration',  () => {
        $(this).collapse();
      })
    }
  }
</script>
