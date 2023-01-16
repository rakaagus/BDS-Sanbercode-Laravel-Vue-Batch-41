<template>
  <div>
    <v-alert :type="alert.alert_variant" v-if="alert.show_alert" class="my-2">
      {{ alert.alert_msg }}
    </v-alert>
  </div>
  <dialog-tambah :submitDataCampaign="submitDataCampaign" />
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
      <tr v-for="item in data" :key="item.id">
        <td>{{ item.title }}</td>
        <td>{{ item.required }}</td>
        <td>{{ item.collected }}</td>
        <td class="d-flex mt-5">
          <dialog-detail :campaignId="item.id" />
          <dialog-edit :campaignId="item.id" />
          <dialog-delete :campaignId="item.id" />
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import DialogTambah from "./dialogTambah.vue";
import DialogDetail from "./dialogDetail.vue";
import DialogEdit from "./dialogEdit.vue";
import DialogDelete from "./dialogHapus.vue";
export default {
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
    data: [],
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    passwordRules: [(v) => !!v || "Password is required"],
  }),
  methods: {
    async getDataCampaign() {
      try {
        const getData = await axios.get("/api/campaign");
        const data = getData.data.data.campaign;
        this.data = data;
      } catch (error) {
        console.log(error);
      }
    },
    async submitDataCampaign() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.alert.show_alert = true;
        this.alert.alert_variant = "warning";
        this.alert.alert_msg = "please waits";

        try {
          const getData = await axios.post("/api/campaign", this.campaign);
          this.alert.show_alert = true;
          this.alert.alert_variant = "success";
          this.alert.alert_msg = getData.data.response_message;

          this.dialog = false;
          this.$emit("getDataCampaign");
        } catch (error) {
          console.log(error);
        }
      }
    },
  },
  created() {
    this.getDataCampaign();
  },
};
</script>

