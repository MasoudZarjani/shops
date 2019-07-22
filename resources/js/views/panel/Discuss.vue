<template>
  <v-container>
    <v-toolbar flat>
      <v-dialog
        v-model="dialog"
        max-width="600px"
      >
        <template v-slot:activator="{ on }">
          
          <v-text-field
            v-model="search"
            append-icon="search"
            label="جستجو"
            single-line
            hide-details
          ></v-text-field>

        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12 >
                  <v-text-field v-model="editedItem.product" label="نام کالا*" ></v-text-field>
                </v-flex>
                 <v-flex xs12 sm6 md6 >
                  <v-text-field
                    v-model="editedItem.user"
                    label="نام کاربر*" ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6 >
                  <v-text-field
                    v-model="editedItem.title"
                    label="عنوان*" ></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12 >
                  <v-text-field
                    v-model="editedItem.description"
                    label="توضیحات*" ></v-text-field>
                </v-flex>
                <v-flex xs12 sm4 md4 >
                  <v-switch v-model="editedItem.status" label="وضعیت" ></v-switch>
                </v-flex>
                
                <v-flex xs12 sm4 md4>
                  <img v-if="fileUser!==''" :src="fileUser" class="img-responsive" />
                  <img v-else :src="editedItem.file_user" class="img-responsive" />
                </v-flex>
                
                <v-flex xs12 sm4 md4>
                  <img v-if="fileAdmin!==''" :src="fileAdmin" class="img-responsive" />
                  <img v-else :src="editedItem.file_admin" class="img-responsive" />
                </v-flex>
                <v-flex xs12 sm8 md8>
                  <input type="file" v-on:change="onFileChange" />
                </v-flex>
              </v-layout>
            </v-container>
            <small>* فیلدهای الزامی را مشخص می نماید.</small>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="primary darken-1"
              flat
              @click="close"
            >رد</v-btn>
            <v-btn
              color="primary darken-1"
              flat
              @click="save"
            >ذخیره</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="results"
      :pagination.sync="pagination"
      :total-items="total"
      :rows-per-page-items="rowsPerPageItems"
      :loading="loading"
      class="elevation-1"
    >
      <template v-slot:items="props">
        <td>{{ (pagination.rowsPerPage*(pagination.page-1))+(props.index+1) }}</td>
       
        <td class="text-xs-center">{{ props.item.user }}</td>
        <td class="text-xs-center">{{ props.item.title }}</td>
        <td class="text-xs-center">{{ props.item.product }}</td>
        <td class="text-xs-center">
          <v-switch
            v-model="props.item.status"
            @change="changeState(props.item.id)"
          ></v-switch>
        </td>
        <td>
          <v-icon small class="mr-2" color="blue" @click="editItem(props.item)" >mdi-pencil</v-icon>
        </td>
      </template>
    </v-data-table>
    <v-snackbar
      v-model="snack"
      :timeout="3000"
      :color="snackColor"
    >
      {{ snackText }}
      <v-btn
        flat
        @click="snack = false"
      >Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import Api from "../../api/Message.js";

export default {
  data: () => ({
    snack: false,
    modal: false,
    snackColor: "",
    snackText: "",
    fileUser: "",
    fileAdmin: "",
    results: [],
    search: "",
    total: 0,
    loading: false,
    pagination: {},
    dialog: false,
    editedIndex: -1,
    editedItem: {
      file_admin: "",
      title: "",
      description: "",
      status: 0,
    },
    defaultItem: {
      file_admin: "",
      title: "",
      description: "",
      status: 0,
    },
    headers: [
        { text: "ردیف", value: "id", align: "center" },
        { text: "نام کاربر", value: "user", align: "center" },
        { text: "عنوان", value: "title", align: "center" },
        { text: "نام کالا", value: "product", align: "center" },
        { text: "وضعیت", value: "status", align: "center" },
        { text: "عملیات", value: "action", align: "center" }
    ],
    rowsPerPageItems: [5, 10, 20, 50, 100]
  }),
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "افزودن" : "ویرایش";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    pagination: {
      handler() {
        this.getByPagination();
      }
    },
    search() {
      this.getByPagination();
    }
  },
  methods: {

    getByPagination() {
      this.loading = true;
      if (this.search) {
        Api.getFilterDiscuss({
          query: this.search,
          page: this.pagination.page,
          per_page: this.pagination.rowsPerPage
        })
          .then(res => {
            this.results = res.data.data;
            this.total = res.data.meta.total;
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false));
      }

      // get by sort option
      if (this.pagination.sortBy && !this.search) {
        const direction = this.pagination.descending ? "desc" : "asc";
        Api.getOrderDiscuss({
          direction: direction,
          sortBy: this.pagination.sortBy,
          page: this.pagination.page,
          per_page: this.pagination.rowsPerPage,
        }).then(res => {
          console.log(res);
          this.loading = false;
          this.results = res.data.data;
          this.total = res.data.meta.total;
        });
      }
      if (!this.search && !this.pagination.sortBy) {
        Api.getDiscuss({
          page: this.pagination.page,
          per_page: this.pagination.rowsPerPage
        })
          .then(res => {
            this.loading = false;
            this.results = res.data.data;
            this.total = res.data.meta.total;
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false));
      }
    },

    editItem(item) {
      this.editedIndex = this.results.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 1000);
    },

    save() {
console.log(this.fileAdmin);
      this.editedItem.file_admin = this.fileAdmin;
      if (this.editedIndex > -1) {
        
        Api.updateDiscuss(this.editedItem)
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
      } 
    //   else {
    //     Api.create(this.editedItem)
    //       .then(({ data }) => {
    //         this.snack = true;
    //         this.snackColor = "success";
    //         this.snackText = this.$t("message.create.success");
    //         this.results.push(data.data);
    //         this.getByPagination();
    //       })
    //       .catch(error => {
    //         this.snack = true;
    //         this.snackColor = "error";
    //         this.snackText = this.$t("message.create.error");
    //       });
    //   }
      this.close();
    },

    changeState(item) {
      Api.changeStateDiscuss(item)
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
        vm.fileAdmin = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }
};
</script>

<style scoped>
.headline {
  font-family: iranyekan !important;
}

img {
  max-height: 100px;
}
</style>