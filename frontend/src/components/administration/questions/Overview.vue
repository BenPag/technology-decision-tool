<template>
  <div id="administrationQuestionOverview">
    <div class="row">
      <div class="col-7">
        <table class="table table-sm table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Frage</th>
              <th scope="col" />
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="question in questions"
              :key="question.id"
              :class="{'table-primary': selectedQuestionToEdit.id === question.id}"
              class="cursor-pointer"
              @click="setQuestionToEdit(question)">
              <td>{{ question.id }}</td>
              <td>{{ question.question }}</td>
              <td
                class="text-secondary text-center align-middle"
                @click="deleteQuestion(question)">
                <fa icon="trash" />
              </td>
            </tr>
            <tr
              class="table-success cursor-pointer"
              @click="setQuestionToEdit(emptyQuestion)">
              <td class="text-center align-middle">
                <fa icon="plus" />
              </td>
              <td>Neue Frage anlegen</td>
              <td />
            </tr>
          </tbody>
        </table>
      </div>
      <div
        v-if="selectedQuestionToEdit"
        class="col-5">
        <questionCreator :question="selectedQuestionToEdit"/>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from "vuex";
  import QuestionCreator from "./Form";

  export default {
    name: 'AdministrationQuestionOverview',
    title: 'Übersicht - Fragen',
    components: {
      QuestionCreator
    },
    data () {
      return { }
    },
    computed: {
      ...mapState({
        questions: state => state.questions.all,
        selectedQuestionToEdit: state => state.questions.selectedQuestionToEdit,
        emptyQuestion: state => state.questions.emptyQuestion
      })
    },
    created () {
      this.getAllQuestions();
    },
    methods: {
      ...mapActions('questions', [
        'getAllQuestions',
        'setQuestionToEdit',
        'deleteQuestion'
      ])
    }
  }
</script>
