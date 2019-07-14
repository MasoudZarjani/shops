<template v-slot:extension>
  <v-container>
    <v-card>
      <v-layout row>
        <v-layout xs3 align-center justify-center>
          <v-flex 12>
            <v-img :src="items.avatar" height="125px" contain></v-img>
          </v-flex>
        </v-layout>
        <v-flex xs6>
          <v-card-title>
            <v-flex xs12>
              <v-flex xs12 class="subheading font-weight-black mb-2">{{ items.full_name }}</v-flex>
              <v-layout xs12 row>
                <v-flex xs4>
                  <v-icon small>mdi-deskphone</v-icon>
                  {{ items.mobile }}
                </v-flex>
                <v-flex xs4>
                  <v-icon small>mdi-calendar-plus</v-icon>
                  {{ items.created_at }}
                </v-flex>
              </v-layout>
            </v-flex>
          </v-card-title>
        </v-flex>
        <v-flex xs3>
          <v-flex xs6>
            <a :href="items.social.facebook" target="_blank">
              <v-icon large>mdi-facebook</v-icon>
            </a>
          </v-flex>
          <v-flex xs6>
            <a :href="items.social.twitter" target="_blank">
              <v-icon large>mdi-twitter</v-icon>
            </a>
          </v-flex>
          <v-flex xs6>
            <a :href="items.social.instagram" target="_blank">
              <v-icon large>mdi-instagram</v-icon>
            </a>
          </v-flex>
          <v-flex xs6>
            <a :href="items.social.telegram" target="_blank">
              <v-icon large>mdi-telegram</v-icon>
            </a>
          </v-flex>
        </v-flex>
      </v-layout>
      <v-divider light></v-divider>
      <v-card-actions class="pa-3">
        عملیات
        <v-spacer></v-spacer>
        <v-btn icon>
          <v-icon>favorite</v-icon>
        </v-btn>
      </v-card-actions>
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
    rowsPerPageItems: [4, 8, 12],
    pagination: {
      rowsPerPage: 4
    },
    snack: false,
    snackColor: "",
    snackText: "",
    items: []
  }),
  mounted() {
    this.getDetail();
  },
  methods: {
    getDetail() {
      this.snack = false;
      Api.getDetail(this.$route.params.id)
        .then(result => {
          this.items = result.data.data;
          console.log(this.items);
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

