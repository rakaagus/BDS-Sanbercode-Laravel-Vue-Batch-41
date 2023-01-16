<template>
  <v-card class="mx-auto" max-width="700" variant="outlined">
    <div>
      <v-alert :type="alert.alert_variant" v-if="alert.show_alert" class="my-2">
        {{ alert.alert_msg }}
      </v-alert>
    </div>
    <v-card-item>
      <div>
        <div class="text-h3 text-center text-primary my-3">
          Verifikasi email
        </div>
        <div class="text-caption text-center my-3"></div>
      </div>
    </v-card-item>
    <v-card-text>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
          v-model="otp"
          :rules="otpRules"
          label="otp codes"
          type="number"
        ></v-text-field>

        <v-btn color="success" block class="mr-4" @click="verificationAkun">
          Verifikasi
        </v-btn>
      </v-form>
    </v-card-text>
    <v-card-text>
      <div class="text-caption text-center">
        Generate Ulang Otp Code
        <a href="#" @click="generateOtpCode">Klick Disini</a>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions, mapWritableState } from "pinia";
import { useUserStore } from "@/store/user";
import axios from "axios";
export default {
  data() {
    return {
      alert: {
        show_alert: false,
        alert_variant: "",
        alert_msg: null,
      },
      valid: false,
      otp: null,
      otpRules: [
        (v) => !!v || "Otp is required",
        (v) => (v && v.length <= 6) || "Maksimal 6 charakter",
      ],
    };
  },
  computed: {
    ...mapWritableState(useUserStore, ["user"]),
  },
  methods: {
    ...mapActions(useUserStore, ["verificationSuccess"]),
    async verificationAkun() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.alert.show_alert = true;
        this.alert.alert_variant = "warning";
        this.alert.alert_msg = "please waits";

        try {
          const verification = await axios.post("/api/auth/verifikasi-email", {
            otp: this.otp,
          });

          this.alert.show_alert = true;
          this.alert.alert_variant = "success";
          this.alert.alert_msg = verification.data.response_message;

          this.$router.push("/");
          this.verificationSuccess();
        } catch (error) {
          this.alert.show_alert = true;
          this.alert.alert_variant = "error";
          this.alert.alert_msg = error.response.data.response_message;
          //   console.log(error);
        }
      }
    },
    async generateOtpCode() {
      this.alert.show_alert = true;
      this.alert.alert_variant = "warning";
      this.alert.alert_msg = "please waits";
      try {
        const generate = await axios.post("/api/auth/generate-otp-code", {
          email: this.user.email,
        });

        this.alert.show_alert = true;
        this.alert.alert_variant = "success";
        this.alert.alert_msg = generate.data.response_message;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
