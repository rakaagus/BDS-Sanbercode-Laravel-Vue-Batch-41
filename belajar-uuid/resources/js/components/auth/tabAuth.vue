<template>
  <v-card color="success">
    <v-tabs v-model="tab" bg-color="tranparent" color="secondary" grow>
      <v-tab value="login">Login</v-tab>
      <v-tab value="register">Register</v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="login">
          <v-card color="white" flat>
            <v-card-text>
              <login-form @closeDialog="closeDialog" />
            </v-card-text>
          </v-card>
        </v-window-item>

        <v-window-item value="register">
          <v-card color="white" flat>
            <v-card-text>
              <register-form />
            </v-card-text>
          </v-card>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
import LoginForm from "./loginForm.vue";
import RegisterForm from "./registerForm.vue";
export default {
  emits: ["closeDialog"],
  data: () => ({
    tab: null,
  }),
  components: {
    LoginForm,
    RegisterForm,
  },
  methods: {
    closeDialog() {
      this.$emit("closeDialog");
    },
  },
};
</script>
