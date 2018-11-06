<template>
  <div id="app">
    <div id="loading" v-if="loading">
      <img src="img/loading.svg" alt="Loading..."/>
    </div>
    <navbar></navbar>
    <div id="content">
      <router-view/>
    </div>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';

export default {
  components: {
    Navbar,
  },
  computed: {
    loading() {
      return this.$store.state.loading;
    },
  },
};
</script>

<style scoped>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }

  #content {
    padding: 30px;
  }

  #loading {
    width: 100vw;
    height: 100vh;
    position: absolute;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.5);
    font-size: 30px;
    color: white;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center
  }

  #nav a {
    font-weight: bold;
    color: #2c3e50;
  }
</style>
