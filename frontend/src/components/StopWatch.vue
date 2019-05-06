<template>
  <div class="row">
    <div
      id="timer"
      class="text-center col-6">
      <span id="minutes">{{ minutes }}</span>
      <span id="middle">:</span>
      <span id="seconds">{{ seconds }}</span>
    </div>
    <div
      id="buttons"
      class="row mt-2 col-6">
      <div>
        <button
          v-if="!timer"
          id="start"
          class="btn btn-pico-inverse"
          @click="startTimer">
          Start
        </button>
        <button
          v-if="timer"
          id="stop"
          class="btn btn-pico-inverse"
          @click="stopTimer">
          Stop
        </button>
        <button
          v-if="resetButton"
          id="reset"
          class="btn btn-dark"
          @click="resetTimer">
          Reset
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'StopWatch',
    data () {
      return {
        timer: null,
        totalTime: (0),
        resetButton: false,
      }
    },
    computed: {
      minutes () {
        const minutes = Math.floor(this.totalTime / 60);
        return this.padTime(minutes);
      },
      seconds () {
        return this.padTime(this.totalTime - (this.minutes * 60));
      }
    },
    methods: {
      startTimer () {
        this.timer = setInterval(() => this.countdown(), 1000);
        this.resetButton = true;
      },
      stopTimer () {
        clearInterval(this.timer);
        this.timer = null;
        this.resetButton = true;
      },
      resetTimer () {
        this.totalTime = (0);
        clearInterval(this.timer);
        this.timer = null;
        this.resetButton = false;
      },
      padTime (time) {
        return (time < 10 ? '0' : '') + time;
      },
      countdown () {
        this.totalTime++;
      }
    }
  }
</script>
