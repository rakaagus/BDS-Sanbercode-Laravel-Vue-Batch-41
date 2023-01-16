<template>
  <v-row justify="left">
    <v-dialog v-model="dialog" width="400">
      <template v-slot:activator="{ props }">
        <v-btn variant="tonal" class="bg-danger mx-2" v-bind="props">
          <v-icon left>mdi-delete</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>Hapus Data</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 70px" class="text-center">
          <h3>Yakin Hapus Data?</h3>
        </v-card-text>
        <v-card-actions>
          <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
            Close
          </v-btn>
          <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
            Save
          </v-btn>
        </v-card-actions>
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
