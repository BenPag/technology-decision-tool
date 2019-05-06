<template>
  <div class="col-10 offset-1 mb-4">
    <div class="row mb-3">
      <div class="col-8">
        <h2>Dein QQ2-Projekt Fortschritt</h2>
      </div>
      <div class="col-4 pl-5">
        <stopWatch class="ml-auto"/>
      </div>
    </div>
    <div class="progress">
      <div
        :class="progress < 98 ? 'bg-pico' : 'bg-success'"
        :aria-valuenow="progress"
        :style="{ width: progress + '%' }"
        class="progress-bar"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="100" />
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import StopWatch from "./StopWatch";

  export default {
    name: 'Progress',
    components: { StopWatch },
    computed: {
      ...mapGetters('auth', {
        progress: 'getMyProgress'
      }),
    },
  }
</script>
