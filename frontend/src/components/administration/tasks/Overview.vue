<template>
  <div id="administrationTaskOverview">
    <div class="row">
      <div class="col-3">
        <table class="table table-bordered table-hover">
          <tbody>
            <tr
              v-for="task in tasks"
              :key="task.id"
              :class="{'table-primary': selectedTaskToEdit && selectedTaskToEdit.id === task.id}"
              class="cursor-pointer"
              @click="setTaskToEdit(task)">
              <td>{{ task.title }}</td>
              <td
                class="text-dark text-center align-middle"
                @click="deleteTask(task)">
                <fa icon="trash" />
              </td>
            </tr>
            <tr
              class="table-success cursor-pointer"
              @click="setTaskToEdit(emptyTask)">
              <td>Neue Aufgabe anlegen</td>
              <td class="text-center align-middle">
                <fa icon="plus" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div
        v-if="selectedTaskToEdit"
        class="col-9">
        <taskCreator :task="selectedTaskToEdit"/>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from "vuex";
  import TaskCreator from "./Form";

  export default {
    name: 'AdministrationTaskOverview',
    title: 'Übersicht - Aufgaben',
    components: {
      TaskCreator
    },
    data () {
      return { }
    },
    computed: {
      ...mapState({
        tasks: state => state.tasks.all,
        selectedTaskToEdit: state => state.tasks.selectedTaskToEdit,
        emptyTask: state => state.tasks.emptyTask
      })
    },
    created () {
      this.getAllTasks();
    },
    methods: {
      ...mapActions('tasks', [
        'getAllTasks',
        'setTaskToEdit',
        'deleteTask'
      ])
    }
  }
</script>
