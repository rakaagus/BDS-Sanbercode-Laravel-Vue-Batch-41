<template>
  <v-container class="bg-white">
    <v-row no-gutters>
      <v-col
        v-for="campaign in campaigns"
        :key="'campaign-' + campaign.id"
        cols="12"
        sm="6"
        class="mt-2"
      >
        <campaign-item :campaign="campaign" class="ml-2"></campaign-item>
      </v-col>
    </v-row>
  </v-container>
  <v-pagination
    v-model="page"
    @click="getCampaign"
    :length="lengthPage"
  ></v-pagination>
</template>

<script>
import CampaignItem from "../components/CampaignItem.vue";
export default {
  data() {
    return {
      page: 1,
      lengthPage: 0,
      campaigns: [],
    };
  },
  components: {
    CampaignItem,
  },
  created() {
    this.getCampaign();
  },
  methods: {
    getCampaign() {
      let url = "/api/gatallcampaign?page=" + this.page;

      axios
        .get(url)
        .then((response) => {
          let { data } = response.data;
          this.campaigns = data.campaign.data;
          this.page = data.campaign.current_page;
          this.lengthPage = data.campaign.last_page;
        })
        .catch((error) => {
          let { response } = error;
          console.log(response);
        });
    },
  },
};
</script>
