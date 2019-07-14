<template v-slot:extension>
  <v-container>
    <v-card>
      <v-card-title>
        <v-flex>
          <v-img :src="data.avatar" width="100px"></v-img>
        </v-flex>
        <v-flex>
          <div class="subheading font-weight-black">
            {{ data.full_name }}
            <v-tooltip bottom v-if="data.status == true">
              <template v-slot:activator="{ on }">
                <v-icon small color="green" v-on="on">mdi-circle</v-icon>
              </template>
              <span>فعال</span>
            </v-tooltip>
            <v-tooltip bottom v-else>
              <template v-slot:activator="{ on }">
                <v-icon small color="red" v-on="on">mdi-circle</v-icon>
              </template>
              <span>فعال</span>
            </v-tooltip>
          </div>
          <div class="mt-2">
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <span v-on="on">
                  <v-icon small>mdi-phone</v-icon>
                  {{ data.mobile }}
                </span>
              </template>
              <span>شماره تماس</span>
            </v-tooltip>
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <span v-on="on">
                  <v-icon small>mdi-calendar-plus</v-icon>
                  {{ data.created_at }}
                </span>
              </template>
              <span>تاریخ ثبت</span>
            </v-tooltip>
          </div>
        </v-flex>
        <v-spacer></v-spacer>
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn color="primary" fab small v-on="on">
              <v-icon>edit</v-icon>
            </v-btn>
          </template>
          <span>ویرایش</span>
        </v-tooltip>
      </v-card-title>
      <v-layout row>
        <v-flex xs10>
          <v-card-text></v-card-text>
        </v-flex>
      </v-layout>
      <v-divider light></v-divider>
      <v-card-actions class="pa-3">
        <v-layout xs12>
          <v-flex class="text-xs-center">
            <v-icon>mdi-facebook</v-icon>فیسبوک
          </v-flex>
          <v-flex class="text-xs-center">
            <v-icon>mdi-twitter</v-icon>توئیتر
          </v-flex>
          <v-flex class="text-xs-center">
            <v-icon>mdi-telegram</v-icon>تلگرام
          </v-flex>
          <v-flex class="text-xs-center">
            <v-icon>mdi-instagram</v-icon>اینستاگرام
          </v-flex>
        </v-layout>
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

