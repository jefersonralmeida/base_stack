<template>
  <div>
    <h1>Login</h1>
    <div id="container">
      <b-form v-on:submit.prevent="onSubmit" id="form">
        <b-alert variant="danger"
                 dismissible
                 fade
                 v-bind:show="showError"
                 v-on:dismissed="showError=false">
          {{ error }}
        </b-alert>
        <b-form-group description="Endereço de email.">
          <b-form-input id="email" type="email" v-model="form.email" placeholder="Enter email">
          </b-form-input>
        </b-form-group>
        <b-form-group description="Sua senha">
          <b-form-input id="password" type="password" v-model="form.password"
                        placeholder="Enter password"></b-form-input>
        </b-form-group>
        <b-button type="submit" variant="primary">Submit</b-button>
      </b-form>
    </div>
  </div>
</template>

<script>

export default {
  name: 'home',
  data: () => ({
    form: {
      email: '',
      password: '',
    },
    showError: false,
    error: '',
  }),
  methods: {
    onSubmit() {
      this.$store.commit('DISABLE_APP');
      this.$store.dispatch('logIn', this.form)
        .then(() => {
          this.showError = false;
          this.error = '';
          this.$router.push('/');
        })
        .catch((error) => {
          this.error = error.response.data.message;
          this.showError = true;
        })
        .finally(() => {
          this.$store.commit('ENABLE_APP');
        });
    },
  },
};
</script>

<style scoped>
  #container {
    margin: 30px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center
  }

  #form {
    width: 500px;
  }
</style>
