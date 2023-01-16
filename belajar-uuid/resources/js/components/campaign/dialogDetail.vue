<template>
  <v-row justify="left">
    <v-dialog v-model="dialog" width="650">
      <template v-slot:activator="{ props }">
        <v-btn variant="tonal" class="bg-info mx-2" v-bind="props">
          <v-icon left>mdi-alert-circle-outline</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>Detail Data</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px"> </v-card-text>
      </v-card>
    </v-dialog>
  </v-row>
</template>

  <script>
export default {
  data() {
    return {
      dialog: false,
    };
  },
};
</script>
