<template v-slot:extension>
  <v-container>
    <v-card>
      <v-layout>
        <v-flex xs6 sm4 md4>
          <v-card-text style="padding: 0">
            <v-navigation-drawer v-model="drawer" permanent right>
              <v-toolbar height="150" flat class="transparent">
                <v-list two-line class="pa-0">
                  <v-subheader inset>
                    {{ $t('title.userDetail.userInformation') }}
                    <v-spacer></v-spacer>
                    <v-icon color="blue">mdi-chat</v-icon>
                  </v-subheader>
                  <v-list-tile avatar>
                    <v-list-tile-avatar>
                      <img :src="data.avatar" />
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                      <v-list-tile-title>
                        {{ data.full_name }}
                        <v-tooltip bottom v-if="data.status == true">
                          <template v-slot:activator="{ on }">
                            <v-icon small color="green" v-on="on">mdi-circle</v-icon>
                          </template>
                          <span>{{ $t('form.enable') }}</span>
                        </v-tooltip>
                        <v-tooltip bottom v-else>
                          <template v-slot:activator="{ on }">
                            <v-icon small color="red" v-on="on">mdi-circle</v-icon>
                          </template>
                          <span>{{ $t('form.disable') }}</span>
                        </v-tooltip>
                      </v-list-tile-title>
                      <v-list-tile-sub-title>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <span v-on="on">
                              <v-icon small>mdi-calendar-plus</v-icon>
                              {{ data.created_at }}
                            </span>
                          </template>
                          <span>{{ $t('form.createdAt') }}</span>
                        </v-tooltip>
                      </v-list-tile-sub-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-switch
                            v-on="on"
                            v-model="data.status"
                            color="primary"
                            @change="changeState(data.id)"
                          ></v-switch>
                        </template>
                        <span>{{ $t('form.status') }}</span>
                      </v-tooltip>
                    </v-list-tile-action>
                    <span></span>
                  </v-list-tile>
                </v-list>
              </v-toolbar>

              <v-list class="pt-1" dense>
                <v-divider></v-divider>

                <v-list-tile v-for="item in items" :key="item.title" @click="showTab(item.name)">
                  <v-list-tile-action>
                    <v-icon>{{ item.icon }}</v-icon>
                  </v-list-tile-action>

                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </v-navigation-drawer>
          </v-card-text>
        </v-flex>
        <v-flex xs6 sm8 md8>
          <v-card-text v-if="address">address</v-card-text>
          <v-card-text v-if="payment">payment</v-card-text>
          <v-card-text v-if="message">message</v-card-text>
        </v-flex>
      </v-layout>
    </v-card>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
      {{ snackText }}
      <v-btn flat @click="snack = false">{{ $t('general.close') }}</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import Api from "../../api/User.js";

export default {
  data: () => ({
    drawer: true,
    items: [
      { title: "آدرس ها", name: "address", icon: "mdi-map-marker" },
      { title: "پرداخت ها", name: "payment", icon: "mdi-credit-card-settings" },
      { title: "پیام ها", name: "message", icon: "mdi-forum" }
    ],
    right: null,
    modal: false,
    dialog: false,
    address: false,
    payment: false,
    message: false,
    editedIndex: -1,
    editedItem: {
      avatar: "",
      first_name: "",
      last_name: "",
      mobile: "",
      status: 0,
      created_at: ""
    },
    defaultItem: {
      avatar: "",
      first_name: "",
      last_name: "",
      mobile: "",
      status: 0,
      created_at: ""
    },
    file: "",
    snack: false,
    snackColor: "",
    snackText: "",
    data: []
  }),
  mounted() {
    this.getDetail();
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  methods: {
    showTab(name) {
      this.address = false;
      this.payment = false;
      this.message = false;
      switch (name) {
        case "address":
          this.address = true;
          break;
        case "payment":
          this.payment = true;
          break;
        case "message":
          this.message = true;
          break;
        default:
          break;
      }
    },
    getDetail() {
      this.snack = false;
      Api.getDetail(this.$route.params.id)
        .then(result => {
          this.data = result.data.data;
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.userDetail.error");
        });
    },

    editItem(item) {
      this.editedIndex = item.id;
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    save() {
      if (this.file != null) this.editedItem.avatar = this.file;
      this.editedItem.avatar = this.data.avatar;
      if (this.editedIndex > -1) {
        Api.update(this.editedItem)
          .then(() => {
            this.snackColor = "success";
            this.snackText = this.$t("message.update.success");
            this.snack = true;
            let self = this.editedIndex;
            Object.assign(this.results[self], this.editedItem);
          })
          .catch(error => {
            this.snack = true;
            this.snackColor = "error";
            this.snackText = this.$t("message.update.error");
          });
      } else {
        Api.create(this.editedItem)
          .then(({ data }) => {
            this.snack = true;
            this.snackColor = "success";
            this.snackText = this.$t("message.create.success");
            this.results.push(data.data);
            this.getByPagination();
          })
          .catch(error => {
            this.snack = true;
            this.snackColor = "error";
            this.snackText = this.$t("message.create.error");
          });
      }
      this.close();
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 1000);
    },

    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },

    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.file = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    changeState(item) {
      this.snack = false;
      Api.changeState(item)
        .then(() => {
          this.snack = true;
          this.snackColor = "success";
          this.snackText = this.$t("message.changeState.success");
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.changeState.error");
        });
    }
  }
};
</script>

<style scoped>
.left-float {
  float: left !important;
}
.v-card__title {
  align-items: flex-start !important;
  padding: 5px;
}
.v-input--switch {
  padding: 0 !important;
  margin: 0 !important;
}
</style>

