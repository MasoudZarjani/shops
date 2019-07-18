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

          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            class="mb-2"
            v-on="on"
          >افزودن</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12 >
                  <v-text-field v-model="editedItem.title" label="عنوان*" ></v-text-field>
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
        
        <td class="text-xs-center">{{ props.item.title }}</td>
        
        <td>
          <v-icon small class="mr-2" color="blue" @click="editItem(props.item)" >mdi-pencil</v-icon>
          <v-icon small color="red" @click="deleteItem(props.item)" >mdi-delete</v-icon>
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
import Api from "../../api/Category.js";

export default {
  data: () => ({
    snack: false,
    modal: false,
    snackColor: "",
    snackText: "",
    file: "",
    results: [],
    search: "",
    total: 0,
    loading: false,
    pagination: {},
    dialog: false,
    editedIndex: -1,

    editedItem: {
      title: "",
    },
    defaultItem: {
      title: "",
    },
    headers: [
      { text: "ردیف", value: "id", align: "center" },
      { text: "عنوان", value: "title", align: "center" },
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
        Api.getComments(this.$route.params.id)
          .then(res => {
            console.log(res.data.data);
            this.loading = false;
            this.results = res.data.data;
            this.total = res.data.meta.total;
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false));
    },

    editItem(item) {
      this.editedIndex = this.results.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.results.indexOf(item);
      if (confirm("از حذف مطمئن هستید؟")) {
        Api.deleteComment(item.id)
          .then(() => {
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
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 1000);
    },

    save() {
this.editedItem.categoryId = this.$route.params.id;
      if (this.editedIndex > -1) {
        console.log();
        Api.updateComment(this.editedItem)
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
        Api.createComment(this.editedItem)
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

