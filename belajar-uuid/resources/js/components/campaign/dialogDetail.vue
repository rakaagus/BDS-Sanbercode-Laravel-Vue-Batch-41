<template>
  <v-row justify="left">
    <v-dialog v-model="dialog" width="650">
      <template v-slot:activator="{ props }">
        <v-btn variant="tonal" class="bg-info mx-2" v-bind="props">
          <v-icon left>mdi-alert-circle-outline</v-icon>
        </v-btn>
      </template>
      <v-container>
        <v-row justify="space-around">
          <v-card width="400">
            <v-img
              height="200"
              src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
              cover
              class="text-white"
            >
              <v-toolbar color="rgba(0, 0, 0, 0)" theme="dark">
                <template v-slot:prepend>
                  <v-btn icon="$menu"></v-btn>
                </template>

                <v-toolbar-title class="text-h6">
                  Detail Campaign
                </v-toolbar-title>

                <template v-slot:append>
                  <v-btn icon="mdi-dots-vertical"></v-btn>
                </template>
              </v-toolbar>
            </v-img>

            <v-card-text>
              <div class="font-weight-bold ml-1 mb-2">
                {{ campaign.title }}
              </div>
              <div class="ml-1 mb-2">
                <v-icon>mdi-location</v-icon>{{ campaign.address }}
              </div>
              <div class="ml-1 mb-2">
                {{ campaign.required }}
              </div>
              <div class="ml-1 mb-2">
                {{ campaign.collected }}
              </div>
            </v-card-text>
          </v-card>
        </v-row>
      </v-container>
    </v-dialog>
  </v-row>
</template>

  <script>
export default {
  data() {
    return {
      dialog: false,
      campaign: {
        title: "",
        description: "",
        address: "",
        required: null,
        collected: null,
      },
    };
  },
  props: ["campaignId"],
  methods: {
    async getDetailData() {
      try {
        const getData = await axios.get(`/api/campaign/${this.campaignId}`);
        const data = getData.data.data;
        this.campaign.title = data.title;
        this.campaign.description = data.description;
        this.campaign.address = data.address;
        this.campaign.required = data.required;
        this.campaign.collected = data.collected;

        console.log(getData);
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.getDetailData();
  },
};
</script>
