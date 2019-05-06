<template>
  <div id="app">
    <navigation />
    <progressBar v-if="isLoggedIn && !(this.$route.path.indexOf('admin') !== -1)"/>
    <div class="container-fluid">
      <div class="row">
        <div class="col-1" />
        <div class="col-10">
          <router-view/>
        </div>
        <div class="col-1" />
      </div>
    </div>
  </div>
</template>

<script>
  import Navigation from "./components/Navbar";
  import ProgressBar from "./components/Progress";
  import {mapActions, mapState} from "vuex";

  export default {
    name: 'App',
    components: { Navigation, ProgressBar },
    computed: mapState({
      isLoggedIn: state => state.auth.isLoggedIn,
      me: state => state.auth.me,
      tokenExpiredAt: state => state.auth.tokenExpiredAt,
      steps: state => state.steps.all,
    }),
    created() {
      if (this.isLoggedIn && (this.me === undefined || this.me === null)) {
        this.getMe();
      }
      setInterval(function () {
        this.checkTokenExpirationTime();
      }.bind(this), 45*60*1000);
    },
    methods: {
      ...mapActions('auth', [
        'getMe',
        'refresh'
      ]),
      ...mapActions('steps', [
        'getAllSteps'
      ]),
      checkTokenExpirationTime () {
        console.log("checkTokenExpirationTime");
        if (Date.now() > this.tokenExpiredAt) {
          this.refresh()
        }
      }
    }
  }
</script>
