<template>
  <v-card class="mx-auto" width="800" prepend-icon="mdi-home">
    <template v-slot:title> Campaign </template>

    <v-card-text class="mt-6">
      <table-campaign :getDataCampaign="getDataCampaign" />
    </v-card-text>
  </v-card>
</template>

<script>
import TableCampaign from "../components/campaign/tableCampaign.vue";
export default {
  methods: {
    async getDataCampaign() {
      try {
        const getData = await axios.get("/api/campaign");
        console.log(getData);
        // const data = getData.data.data.campaign;
        // return data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.getDataCampaign();
  },
  components: {
    TableCampaign,
  },
};
</script>
