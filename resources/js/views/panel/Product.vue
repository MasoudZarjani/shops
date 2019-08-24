<template>
  <v-container>
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="headline primary" primary-title>حذف کاربر</v-card-title>

        <v-card-text>آیا از حذف کاربر مطمئن هستید؟</v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialog = false">رد</v-btn>
          <v-btn color="primary" flat @click="deleteItem">تایید</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
        <td>{{ props.index+1 }}</td>
        <td class="text-xs-center">
          <v-img width="80" :src="props.item.image"></v-img>
        </td>
        <td class="text-xs-center">{{ props.item.title }}</td>
        <td class="text-xs-center">{{ props.item.category }}</td>
        <td class="text-xs-center">{{ props.item.brand }}</td>
        <td class="text-xs-center">
          <span v-if="props.item.status == 1">فعال</span>
          <span v-else>غیر فعال</span>
        </td>
        <td class="text-xs-center">
          <v-icon
            small
            @click="$router.push({ path: `/product/detail/${props.item.id}` })"
          >mdi-pencil</v-icon>
          <v-icon small @click="deleteDialog(props.item)">mdi-delete</v-icon>
        </td>
      </template>
    </v-data-table>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
      {{ snackText }}
      <v-btn flat @click="snack = false">بستن</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import Api from "../../api/Product.js";

export default {
  data: () => ({
    snack: false,
    dialog: false,
    deleteId: 0,
    snackColor: "",
    snackText: "",
    results: [],
    search: "",
    total: 0,
    loading: false,
    pagination: {},
    headers: [
      { text: "ردیف", value: "id", align: "center" },
      { text: "تصویر ",value: "avatar",align: "center",sortable: false},
      { text: "عنوان محصول", value: "title", align: "center" },
      { text: "دسته بندی", value: "category", align: "center" },
      { text: "برند", value: "brand", align: "center" },
      { text: "وضعیت", value: "status", align: "center" },
      { text: "عملیات", value: "action", align: "center" }
    ],
    rowsPerPageItems: [5, 10, 20, 50, 100]
  }),
  watch: {
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
        Api.getFilter({
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
        Api.getOrder({
          direction: direction,
          sortBy: this.pagination.sortBy,
          page: this.pagination.page,
          per_page: this.pagination.rowsPerPage
        }).then(res => {
          this.loading = false;
          this.results = res.data.data;
          this.total = res.data.meta.total;
        });
      }
      if (!this.search && !this.pagination.sortBy) {
        Api.get({
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

    deleteDialog(item) {
      this.deleteId = item;
      this.dialog = true;
    },

    deleteItem() {
      let index = this.results.indexOf(this.deleteId);
      this.dialog = false;
      Api.delete(this.deleteId.id)
        .then(res => {
          this.results.splice(index, 1);
          this.snack = true;
          this.snackColor = "success";
          this.snackText = this.$t("message.delete.success");
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.delete.error");
        });
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 1000);
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
.headline {
  font-family: iranyekan !important;
}

img {
  max-height: 100px;
}
</style>

