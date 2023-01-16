<template>
  <v-row justify="left">
    <v-dialog v-model="dialog" width="650">
      <template v-slot:activator="{ props }">
        <v-btn variant="tonal" class="bg-success mx-2" v-bind="props">
          <v-icon left>mdi-pencil</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>Edit Data</v-card-title>
        <v-divider></v-divider>
        <div>
          <v-alert
            :type="alert.alert_variant"
            v-if="alert.show_alert"
            class="my-2"
          >
            {{ alert.alert_msg }}
          </v-alert>
        </div>
        <v-card-text style="height: auto">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
              v-model="campaign.title"
              :counter="10"
              :rules="titleRules"
              label="title"
              type="text"
              required
            ></v-text-field>

            <v-text-field
              v-model="campaign.required"
              :counter="10"
              :rules="requiredRules"
              label="required"
              type="number"
              required
            ></v-text-field>

            <v-text-field
              v-model="campaign.collected"
              :counter="10"
              :rules="collectedRules"
              label="collected"
              type="number"
              required
            ></v-text-field>

            <v-textarea
              label="description"
              no-resize
              rows="4"
              v-model="campaign.description"
              :rules="descriptionRules"
            ></v-textarea>

            <v-textarea
              label="address"
              no-resize
              rows="2"
              v-model="campaign.address"
              :rules="addressRules"
            ></v-textarea>

            <v-file-input chips label="Image"></v-file-input>

            <v-btn color="warning" @click="submitDataCampaign">
              Reset Validation
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
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
      alert: {
        show_alert: false,
        alert_variant: "",
        alert_msg: null,
      },
      titleRules: [(v) => !!v || "title is required"],
      requiredRules: [(v) => !!v || "required is required"],
      collectedRules: [(v) => !!v || "collected is required"],
      descriptionRules: [(v) => !!v || "description is required"],
      addressRules: [(v) => !!v || "address is required"],
    };
  },
};
</script>
