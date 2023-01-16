<template>
  <v-card class="mx-auto" width="800" prepend-icon="mdi-home">
    <template v-slot:title> Campaign </template>

    <v-card-text class="mt-6">
      <table-campaign />
    </v-card-text>
  </v-card>
</template>

<script>
import TableCampaign from "../components/campaign/tableCampaign.vue";
export default {
  components: {
    TableCampaign,
  },
};
</script>
