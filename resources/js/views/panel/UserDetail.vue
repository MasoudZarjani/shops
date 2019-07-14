<template v-slot:extension>
  <v-container>
    <v-card>
      <v-layout row>
        <v-flex xs3 align-center justify-center>
          <v-avatar size="125px" color="grey lighten-4">
            <v-img :src="data.avatar" contain></v-img>
          </v-avatar>
        </v-flex>
        <v-flex xs9>
          <v-card-title>
            <v-flex xs6>
              <div class="subheading font-weight-black">{{ data.full_name }}</div>
              <div class="mt-2">
                <v-icon small>mdi-deskphone</v-icon>
                {{ data.mobile }}
                <v-icon small>mdi-calendar-plus</v-icon>
                {{ data.created_at }}
              </div>
            </v-flex>
            <v-flex xs6>
              <v-btn icon class="left-float">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </v-flex>
          </v-card-title>
        </v-flex>
      </v-layout>
      <v-divider light></v-divider>
      <v-card-actions class="pa-3"></v-card-actions>
    </v-card>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
      {{ snackText }}
      <v-btn flat @click="snack = false">بستن</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import Api from "../../api/User.js";

export default {
  data: () => ({
    snack: false,
    snackColor: "",
    snackText: "",
    data: []
  }),
  mounted() {
    this.getDetail();
  },
  methods: {
    getDetail() {
      this.snack = false;
      Api.getDetail(this.$route.params.id)
        .then(result => {
          this.data = result.data.data;
          console.log(this.data);
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.userDetail.error");
        });
    }
  }
};
</script>

<style scoped>
.left-float {
  float: left !important;
}
</style>

