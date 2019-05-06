<template>
  <div class="toDo w-100">
    <h2>{{ task.title }}</h2>
    <div
      class="mt-4 px-4"
      v-html="task.body"/>
  </div>
</template>

<script>
  export default {
    name: "Aufagbe",
    props: {
      'task': {
        type: Object,
        required: true,
        default: function () {
          return { id: 0, body: 'Dummy task', title: 'Dummy task' }
        }
      }
    },
    methods: {

    }
  }
</script>
