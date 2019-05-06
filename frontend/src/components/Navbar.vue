<template>
  <nav class="navbar navbar-expand-lg navbar-light border border-top-0 mb-4 pl-4">
    <router-link
      to="/"
      class="mr-3">QQ2-Tool</router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" />
    </button>
    <div
      v-if="isLoggedIn && routes && routes.length > 0"
      id="navbarNavDropdown"
      class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li 
          v-for="item in routes"
          v-if="showNavItem(item)"
          :key="item.path"
          class="nav-item">
          <router-link
            :to="item.path"
            class="nav-link">{{ item.name }}</router-link>
        </li>
      </ul>
      <ul
        v-if="isLoggedIn && me"
        class="nav navbar-nav ml-lg-auto mr-lg-4">
        <li
          class="nav-item dropdown">
          <a
            id="navbarDropdownMenuLink"
            href="#"
            class="nav-link dropdown-toggle"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            {{ me.name }} <span class="caret" />
          </a>
          <div
            class="dropdown-menu user-menu"
            aria-labelledby="navbarDropdownMenuLink">
            <button
              type="button"
              class="submit-logout"
              @click="logout()">
              <span class="fa fa-btn fa-sign-out" />
              <span>Abmelden</span>
            </button>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
  import {mapState} from 'vuex'
  import StopWatch from "./StopWatch";

  export default {
    name: 'Navigation',
    components: { StopWatch },
    data ()  {
      return {
        routes: this.$router.options.routes
      }
    },
    computed: {
      ...mapState({
        isLoggedIn: state => state.auth.isLoggedIn,
        isAdmin: state => state.auth.isAdmin,
        me: state => state.auth.me,
      }),
    },
    created() {
      if (this.isLoggedIn && this.me === null || this.me === undefined)
        this.$store.dispatch('auth/getMe')
    },
    methods: {
      showNavItem(item) {
        return (!item.meta || this.isAdmin ||
          (item.meta.requiresAuth === true && this.isLoggedIn && !item.meta.requiresAdmin)) &&
          (this.isLoggedIn && !(item.path.toLowerCase().indexOf('login') !== -1))
      },
      logout () {
        console.log("logout");
        this.$store.dispatch('auth/logout')
      }
    },
  }
</script>
