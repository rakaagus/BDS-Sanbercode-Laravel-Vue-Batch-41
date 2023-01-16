<template>
  <div>
    <v-alert :type="alert.alert_variant" v-if="alert.show_alert" class="my-2">
      {{ alert.alert_msg }}
    </v-alert>
  </div>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="user.name"
      :rules="nameRules"
      label="Name"
      type="text"
    ></v-text-field>

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

    <v-text-field
      v-model="user.password_confirmation"
      :rules="passwordRules"
      :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show2 ? 'text' : 'password'"
      label="Password Confirmation "
      @click:append="show2 = !show2"
      required
    ></v-text-field>

    <v-btn color="success" block class="mr-4" @click="registerSubmit">
      Sing-Up
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
  data() {
    return {
      alert: {
        show_alert: false,
        alert_variant: "",
        alert_msg: null,
      },
      valid: true,
      show1: false,
      show2: false,
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      nameRules: [(v) => !!v || "Name is required"],
      passwordRules: [
        (v) => !!v || "Password is required",
        (v) => (v && v.length >= 8) || "Min 8 charakter",
        (confirmation) =>
          confirmation === this.user.password || "Password Must Macth",
      ],
    };
  },

  methods: {
    async registerSubmit() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.alert.show_alert = true;
        this.alert.alert_variant = "warning";
        this.alert.alert_msg = "please waits";

        try {
          const authRegister = await axios.post(
            "/api/auth/register",
            this.user
          );
          this.alert.show_alert = true;
          this.alert.alert_variant = "success";
          this.alert.alert_msg = authRegister.data.response_message;

          const dataUser = authRegister.data.data.user;
          const token = authRegister.data.token;

          await this.userStore.setVerification(dataUser, token);
          this.$router.push("/verification");
          this.$emit("closeDialog");
        } catch (error) {
          console.log(error);
        }
      }
    },
  },
};
</script>
