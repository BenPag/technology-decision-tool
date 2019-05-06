<template>
  <div class="source_tracking row">
    <div class="col-10 offset-1">
      <h2>Quellenerfassung</h2>
      <Form />
      <History />
    </div>
  </div>
</template>

<script>
  import { library } from '@fortawesome/fontawesome-svg-core'
  import { faThumbsUp, faThumbsDown } from '@fortawesome/free-solid-svg-icons'
  import Form from "./Form";
  import History from "./History";

  library.add(faThumbsUp, faThumbsDown);

  export default {
    name: 'SourceTracking',
    components: { Form, History },
    created () {
      this.$store.dispatch('subjects/getAllSubjects');
      this.$store.dispatch('sourceTypes/getAllSourceTypes');
      this.$store.dispatch('sources/getAllSources')
    }
  };
</script>
