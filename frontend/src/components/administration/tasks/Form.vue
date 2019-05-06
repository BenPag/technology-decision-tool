<template>
  <div class="row">
    <div class="col-12">
      <label
        for="title"
        class="font-weight-bold">
        Aufgabentitel
      </label>
      <input
        id="title"
        v-model="task.title"
        type="text"
        class="form-control"
        placeholder="Bitte den Aufgabentitel eingeben"
        @blur="updateTask(task)">
    </div>
    <div class="col-12 mt-3">
      <label class="font-weight-bold">
        Aufgabenbeschreibung
      </label>
      <CKEditor
        :editor="editor"
        :config="editorConfig"
        v-model="task.body"
        @blur="updateTask(task)" />
    </div>
    <div
      v-if="!task.id"
      class="col-12 mt-3">
      <button
        type="button"
        class="btn btn-success d-block ml-auto"
        @click="storeNewTask(task)">
        Aufabe hinzufügen
      </button>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from 'vuex'
  import CKEditor from '@ckeditor/ckeditor5-vue';
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

  export default {
    name: 'TaskForm',
    components: {
      CKEditor: CKEditor.component
    },
    props: {
      'task': {
        type: Object,
        required: true,
        default: function () {
          return { id: 0, title: "Dummy Task", body: "" }
        }
      }
    },
    data () {
      return {
        editor: ClassicEditor,
        editorConfig: {},
      }
    },
    methods: {
     ...mapActions('tasks', [
       'updateTask',
       'storeNewTask'
     ]),
    }
  }
</script>
