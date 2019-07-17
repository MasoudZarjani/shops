<template>
  <v-toolbar app flat :color="backgroundChoice" :dark="darkTheme" class="white--text">
    <v-toolbar-side-icon
      class="hidden-md-and-up"
      v-model="drawer.open"
      @click.stop="drawer.open = !drawer.open"
    ></v-toolbar-side-icon>
    <v-toolbar-title class="font-weight-light">{{ title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
      <v-switch v-model="darkTheme" @change="changeTheme()" color="white"></v-switch>
      <v-icon color="white" @click="logout()">mdi-logout</v-icon>
    </v-toolbar-items>
  </v-toolbar>
</template>
<script>
export default {
  props: ["drawer"],
  data: () => ({
    title: null,
    darkTheme: false,
    backgroundChoice: "gradiant"
  }),

  mounted() {
    this.title = this.$t("menu.list." + this.$route.name);
  },
  watch: {
    $route(val) {
      this.title = this.$t("menu.list." + val.name);
    }
  },

  methods: {
    logout() {
      axios
        .post("/logout")
        .then(response => {
          window.location.href = "/login";
        })
        .catch(err => {
          console.log("logout error");
          console.log(err);
        });
    },

    changeTheme() {
      this.$emit("changeTheme", this.darkTheme);
      if (this.backgroundChoice == "gradiant") this.backgroundChoice = "";
      else this.backgroundChoice = "gradiant";
    }
  }
};
</script>

<style>
.v-input__control {
  height: 100% !important;
}
.v-input__slot {
  height: 100% !important;
}
.gradiant {
  background-image: linear-gradient(to right, #135589, #33d0cd);
}
</style>


