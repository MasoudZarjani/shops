<template>
  <v-toolbar app flat :color="backgroundChoice" :dark="darkTheme">
    <v-toolbar-side-icon
      class="hidden-md-and-up"
      v-model="drawer.open"
      @click.stop="drawer.open = !drawer.open"
    ></v-toolbar-side-icon>
    <v-toolbar-title class="font-weight-light">{{ title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
      <v-switch v-model="darkTheme" @change="changeTheme()" color="white"></v-switch>
      <v-icon @click="logout()">mdi-logout</v-icon>
    </v-toolbar-items>
  </v-toolbar>
</template>
<script>

export default {
  props: ["drawer"],
  data: () => ({
    title: null,
    darkTheme: false,
    backgroundChoice: "primary",
  }),

  mounted() {
    this.title = this.$route.name;
  },
  watch: {
    $route(val) {
      this.title = val.name;
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
      if (this.backgroundChoice == "primary") this.backgroundChoice = "";
      else this.backgroundChoice = "primary";
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
</style>


