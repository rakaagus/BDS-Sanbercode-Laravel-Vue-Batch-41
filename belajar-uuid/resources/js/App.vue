<template>
  <v-app>
    <v-app-bar color="primary" app>
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer">
        </v-app-bar-nav-icon>
      </template>

      <v-toolbar-title>Test App</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-btn icon>
        <v-badge color="orange" overlap>
          <template v-slot:badge>
            <span>3</span>
          </template>
          <v-icon>mdi-cash-multiple</v-icon>
        </v-badge>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer app color="success" v-model="drawer">
      <v-list>
        <v-list-item
          v-if="userStore.isLogin"
          prepend-avatar="https://randomuser.me/api/portraits/men/78.jpg"
          :title="userStore.user.name"
          nav
        >
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <v-list-item
          prepend-icon="mdi-view-dashboard"
          title="Home"
          :to="{ name: 'home' }"
          value="home"
        ></v-list-item>
        <v-list-item
          v-if="userStore.isAdmin"
          prepend-icon="mdi-forum"
          :to="{ name: 'campaign' }"
          title="Campaign"
          value="Campaign"
        ></v-list-item>
        <v-list-item
          v-if="userStore.isNotVerification"
          prepend-icon="mdi-account-alert"
          :to="{ name: 'verification' }"
          title="Verifikasi Account"
          value="verifikasi"
        ></v-list-item>
      </v-list>

      <template v-slot:append>
        <div class="px-2 py-2" v-if="!userStore.isLogin">
          <v-btn block color="primary" class="mb-1" @click="dialog = true">
            <v-icon left>mdi-lock</v-icon>
            login/register
          </v-btn>
        </div>
        <div class="px-2 py-2" v-else-if="userStore.isLogin">
          <v-btn block color="red" @click.prevent="logout()">
            <v-icon left>mdi-lock</v-icon>
            logout
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-main>
      <v-container>
        <v-dialog
          transition="dialog-bottom-transition"
          v-model="dialog"
          width="600"
        >
          <tab-auth @closeDialog="closeDialog"></tab-auth>
        </v-dialog>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>


<script>
import TabAuth from "./components/auth/tabAuth.vue";
import { useUserStore } from "./store/user";
export default {
  name: "App",
  setup() {
    const userStore = useUserStore();
    return { userStore };
  },
  data: () => ({
    drawer: false,
    dialog: false,
  }),
  components: {
    TabAuth,
  },
  methods: {
    closeDialog() {
      this.dialog = false;
    },
    async logout() {
      await this.userStore.removeAuth();
      this.$router.push("/");
    },
  },
};
</script>
