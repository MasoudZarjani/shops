<template v-slot:extension>
  <v-container>
    <v-tabs v-model="active" color="primary" dark slider-color="amber">
      <v-tab
        ripple
        v-for="(tabInformation, key) in tabInformations"
        :key="key"
        :href="'#tab-' + tabInformation.name"
      >
        <v-icon>{{ tabInformation.icon }}</v-icon>
        &nbsp;{{ tabInformation.title }}
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="active">
      <v-tab-item
        v-for="(tabInformation, key) in tabInformations"
        :key="key"
        :value="'tab-' + tabInformation.name"
      >
        <v-card flat>
          <v-card-text>
            <h2>{{ tabInformation.title }}</h2>
            <v-flex xs12>
              <v-card v-if="tabInformation.name == 'information'">
                <v-layout row>
                  <v-flex xs2>
                    <v-img
                      src="https://cdn.vuetifyjs.com/images/cards/halcyon.png"
                      height="125px"
                      contain
                    ></v-img>
                  </v-flex>
                  <v-flex xs4>
                    <v-card-title primary-title>
                      <div>
                        <div
                          class="headline"
                          style="font-family: iranyekan !important"
                        >{{ items.full_name }}</div>
                        <div>{{ items.mobile }}</div>
                        <div>{{ items.created_at }}</div>
                      </div>
                    </v-card-title>
                  </v-flex>
                  <v-flex xs6 row>
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
            </v-flex>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
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
    active: "tab-information",
    rowsPerPageItems: [4, 8, 12],
    pagination: {
      rowsPerPage: 4
    },
    snack: false,
    snackColor: "",
    snackText: "",
    items: [],
    tabInformations: [
      {
        name: "information",
        title: "اطلاعات شخصی",
        icon: "mdi-account-card-details",
        align: "center"
      },
      {
        name: "communication",
        title: "اطلاعات تماس",
        icon: "mdi-contact-phone",
        align: "center"
      },
      {
        name: "device",
        title: "دستگاه ها",
        icon: "mdi-cellphone-link",
        align: "center"
      },
      {
        name: "payment",
        title: "پرداخت ها",
        icon: "mdi-credit-card-settings",
        align: "center"
      }
    ]
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

