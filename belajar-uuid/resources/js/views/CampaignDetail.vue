<template>
  <div>
    <v-card class="mx-auto" max-width="800">
      <v-img
        height="200"
        :src="
          campaign.image
            ? campaign.image
            : 'https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg'
        "
        cover
        class="text-white"
      >
        <v-toolbar color="rgba(0, 0, 0, 0)" theme="dark">
          <template v-slot:prepend>
            <v-btn icon="$menu"></v-btn>
          </template>

          <v-toolbar-title class="text-h6"> Detail Campaign </v-toolbar-title>

          <template v-slot:append>
            <v-btn icon="mdi-dots-vertical"></v-btn>
          </template>
        </v-toolbar>
      </v-img>

      <v-card-title>{{ campaign.title }}</v-card-title>

      <v-card-subtitle class="pt-4">
        <v-icon color="red">mdi-map-marker</v-icon>
        {{ campaign.address }}
      </v-card-subtitle>

      <v-card-text>
        <div class="text-secondary text-h5">Rp. {{ campaign.collected }}</div>
        <div class="text-secondary text-h5">
          Data yang dibutuhkan Rp.
          {{ campaign.required }}
        </div>
      </v-card-text>

      <v-card-actions>
        <v-btn
          block
          size="large"
          @click="donate"
          color="info"
          variant="success"
          :disabled="campaign.collected >= campaign.required"
        >
          <v-icon>mdi-heart</v-icon>DONATE
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import { useUserStore } from "@/store/user";
export default {
  setup() {
    const userStore = useUserStore();
    return { userStore };
  },
  data() {
    return {
      campaign: {},
    };
  },
  created() {
    this.getCampaignDetail();
  },
  methods: {
    getCampaignDetail() {
      let { id } = this.$route.params;
      let url = "/api/campaign/" + id;

      axios
        .get(url)
        .then((response) => {
          this.campaign = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    donate() {
      if (!useUserStore.isLogin) {
        alert("Anda Harus Login Terlebih Dahulu");
      } else if (useUserStore.isNotVerification) {
        alert("Email Anda Belum Diverifikasi");
      } else {
        alert("donate");
      }
    },
  },
};
</script>
