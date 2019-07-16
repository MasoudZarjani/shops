<template v-slot:extension>
  <v-container>
    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>ویرایش</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark flat @click="save">ذخیره</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md6>
                <v-text-field v-model="editedItem.first_name" label="نام*"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md6>
                <v-text-field v-model="editedItem.last_name" label="نام خانوادگی*"></v-text-field>
              </v-flex>
              <v-flex xs6 sm6 md6>
                <input type="file" v-on:change="onFileChange" />
              </v-flex>
              <v-flex xs6 sm6 md6>
                <img v-if="file!==''" :src="file" width="125px" class="img-responsive" />
                <img v-else :src="editedItem.avatar" width="125px" class="img-responsive" />
              </v-flex>
            </v-layout>
          </v-container>
          <small class="red--text darken-4">* فیلدهای الزامی را مشخص می نماید.</small>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-layout>
      <v-spacer></v-spacer>
      <v-btn to="/user" color="primary">بازگشت</v-btn>
    </v-layout>
    <v-card>
      <v-card-title>
        <v-flex xs2 class="pa-2">
          <v-img :src="data.avatar" width="100px"></v-img>
        </v-flex>
        <v-flex class="pa-2">
          <v-layout class="font-weight-black">
            <v-flex xs3>
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
                <span>غیرفعال</span>
              </v-tooltip>
            </v-flex>
            <v-flex xs2>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <span v-on="on">
                    <v-switch v-model="data.status" color="primary" @change="changeState(data.id)"></v-switch>
                  </span>
                </template>
                <span>وضعیت</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
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
            <v-btn color="primary" fab small v-on="on" @click="editItem(data)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
          </template>
          <span>ویرایش</span>
        </v-tooltip>
      </v-card-title>
      <v-divider light></v-divider>
      <v-card-actions class="pa-3">
        <v-layout xs12>
          <v-flex class="text-xs-center">
            <a :href="data.social.facebook">
              <v-icon>mdi-facebook</v-icon>فیسبوک
            </a>
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
    modal: false,
    dialog: false,
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

