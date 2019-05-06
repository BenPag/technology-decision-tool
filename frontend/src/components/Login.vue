<template>
  <div class="login">
    <h2>Anmeldung</h2>
    <form
      @submit.prevent
      @submit="login">
      <div class="form-row">
        <div class="form-group mt-2 col-6 offset-3">
          <label for="username">Benutzername</label>
          <input
            id="username"
            v-model="username"
            type="text"
            class="form-control"
            name="user"
            placeholder="Benuternamen eingeben"
            required
            autofocus>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group mt-2 col-6 offset-3">
          <label for="password">Passwort</label>
          <input
            id="password"
            v-model="password"
            type="password"
            class="form-control"
            name="password"
            placeholder="Passwort eingeben"
            required
            autofocus>
        </div>
      </div>
      <div class="form-row">
        <div class="col-lg-6 offset-3">
          <span
            v-if="errors"
            class="help-block">
            <strong>{{ errors }}</strong>
          </span>
          <button
            type="submit"
            class="btn btn-pico-inverse float-right">
            Anmelden
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import { EventBus } from '../event-bus';

  export default {
    name: 'Login',
    data () {
      return {
        username: '',
        password: '',
        errors: ''
      }
    },
    methods: {
      async login () {
        let credentials = {
          username: this.username,
          password: this.password
        };
        EventBus.$once('loginError', (error) => {
          this.errors = error
        });
        await this.$store.dispatch('auth/login', credentials);
      }
    }
  };
</script>
