<template>
  <div>
    <v-alert :type="alert.alert_variant" v-if="alert.show_alert" class="my-2">
      {{ alert.alert_msg }}
    </v-alert>
  </div>
  <!-- <v-btn variant="tonal" class="bg-info mx-2"
    ><v-icon>mdi-plus</v-icon> Tambah Data</v-btn
  > -->
  <dialog-tambah />
  <v-table class="mt-4">
    <thead>
      <tr>
        <th class="text-left">Title</th>
        <th>Required</th>
        <th>Collected</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in desserts" :key="item.name">
        <td>{{ item.name }}</td>
        <td>{{ item.calories }}</td>
        <td>{{ item.calories }}</td>
        <td class="d-flex mt-5">
          <dialog-detail />
          <dialog-edit />
          <dialog-delete />
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import { useUserStore } from "@/store/user";
import DialogTambah from "./dialogTambah.vue";
import DialogDetail from "./dialogDetail.vue";
import DialogEdit from "./dialogEdit.vue";
import DialogDelete from "./dialogHapus.vue";
export default {
  emits: ["closeDialog"],
  setup() {
    const userStore = useUserStore();
    return { userStore };
  },
  components: {
    DialogTambah,
    DialogDetail,
    DialogEdit,
    DialogDelete,
  },
  data: () => ({
    alert: {
      show_alert: false,
      alert_variant: "",
      alert_msg: "",
    },
    valid: true,
    show1: false,
    desserts: [
      {
        name: "Frozen Yogurt",
        calories: 159,
      },
      {
        name: "Ice cream sandwich",
        calories: 237,
      },
      {
        name: "Eclair",
        calories: 262,
      },
      {
        name: "Cupcake",
        calories: 305,
      },
      {
        name: "Gingerbread",
        calories: 356,
      },
      {
        name: "Jelly bean",
        calories: 375,
      },
      {
        name: "Lollipop",
        calories: 392,
      },
      {
        name: "Honeycomb",
        calories: 408,
      },
      {
        name: "Donut",
        calories: 452,
      },
      {
        name: "KitKat",
        calories: 518,
      },
    ],
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

