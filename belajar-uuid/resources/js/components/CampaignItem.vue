<template>
  <div>
    <v-card :to="'/campaign/' + campaign.id">
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

      <v-card-title class="fill-height align-end" v-text="campaign.title">
      </v-card-title>

      <v-card-actions>
        <v-progress-linear v-model="progress" height="7"></v-progress-linear>
      </v-card-actions>

      <v-card-actions>
        <v-icon> mdi-cash </v-icon>
        <span>Rp. {{ campaign.required.toLocaleString("id-ID") }}</span>
        <v-spacer></v-spacer>
        <span>{{ progress }} %</span>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["campaign"],
  computed: {
    progress() {
      return (this.campaign.collected / this.campaign.required) * 100;
    },
  },
};
</script>
