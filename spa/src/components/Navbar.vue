<template>
  <b-navbar toggleable="md" type="dark" variant="dark">

    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand to="/">
      <img src="img/icons/favicon-32x32.png">
      <p id="brand">Tá na Mão</p>
    </b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">

      <b-navbar-nav>
        <b-nav-item to="/request">Request</b-nav-item>
        <b-nav-item to="/about">About</b-nav-item>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">

        <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form>

        <b-nav-item to="/login" v-if="!logged">Login</b-nav-item>
        <b-nav-item to="/register" v-if="!logged">Register</b-nav-item>

        <b-nav-item-dropdown right v-if="logged" v-bind:disabled="!userName">
          <!-- Using button-content slot -->
          <template slot="button-content">
            <em>{{ userName }}</em>
          </template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item v-on:click="logout">Log Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>

    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$store.commit('DISABLE_APP');
      this.$store.dispatch('logOut').finally(() => { this.$store.commit('ENABLE_APP'); });
      this.$router.push('/');
    },
  },
  computed: {
    logged() {
      return !!this.$store.state.access_token;
    },
    userName() {
      return this.$store.state.user ? this.$store.state.user.name : null;
    },
  },
};
</script>

<style>
  #brand {
    display: inline;
    font-size: 22px;
    padding: 0 0 0 15px;
    font-weight: bold;
  }
</style>
