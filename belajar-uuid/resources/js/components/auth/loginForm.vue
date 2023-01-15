<template>
  <div>
    <v-alert :type="alert.alert_variant" v-if="alert.show_alert" class="my-2">
      {{ alert.alert_msg }}
    </v-alert>
  </div>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="user.email"
      :rules="emailRules"
      label="E-mail"
      type="email"
    ></v-text-field>

    <v-text-field
      v-model="user.password"
      :rules="passwordRules"
      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show1 ? 'text' : 'password'"
      label="Password"
      @click:append="show1 = !show1"
      required
    ></v-text-field>

    <v-btn color="success" block class="mr-4" @click="loginSubmit">
      Sing-in
    </v-btn>
  </v-form>
</template>


<script>
import { useUserStore } from "@/store/user";
export default {
  emits: ["closeDialog"],
  setup() {
    const userStore = useUserStore();
    return { userStore };
  },
  data: () => ({
    alert: {
      show_alert: false,
      alert_variant: "",
      alert_msg: null,
    },
    valid: true,
    show1: false,
    user: {
      email: "",
      password: "",
    },
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    passwordRules: [(v) => !!v || "Password is required"],
  }),

  methods: {
    async loginSubmit() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.alert.show_alert = true;
        this.alert.alert_variant = "warning";
        this.alert.alert_msg = "please waits";

        try {
          const authLogin = await axios.post("/api/auth/login", this.user);
          this.alert.show_alert = true;
          this.alert.alert_variant = "success";
          this.alert.alert_msg = authLogin.data.response_message;

          await this.userStore.setToken(authLogin.data.token);
          this.$emit("closeDialog");
          this.$router.push("/");
        } catch (error) {
          console.log(error);
        }
      }
    },
  },
};
</script>
