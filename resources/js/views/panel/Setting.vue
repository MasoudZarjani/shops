<template>
  <div>
    <v-data-table :headers="headers" :items="results" :loading="loading">
      <template v-slot:items="props">
        <td>{{ props.index+1 }}</td>
        <td>{{ props.item.title }}</td>
        <td class="text-xs-right">
          <v-edit-dialog
            :return-value.sync="props.item.description"
            lazy
            @save="save(props.item)"
            @cancel="cancel"
          >
            <div>{{ props.item.description }}</div>
            <template v-slot:input>
              <div class="mt-3 title">ویرایش محتوی</div>
            </template>
            <template v-slot:input>
              <v-text-field
                v-model="props.item.description"
                :rules="[max2500chars]"
                label="description"
                single-line
                counter
                autofocus
              ></v-text-field>
            </template>
          </v-edit-dialog>
        </td>
      </template>
    </v-data-table>

    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
      {{ snackText }}
      <v-btn flat @click="snack = false">بستن</v-btn>
    </v-snackbar>
  </div>
</template>
<script>
import Api from "../../api/Setting.js";
export default {
  data() {
    return {
      loading: false,
      snack: false,
      snackColor: "",
      snackText: "",
      max25chars: v => v.length <= 25 || "Input too long!",
      pagination: {},
      results: [],
      headers: [
        { text: "ردیف", value: "id", align: "center", sortable: false },
        { text: "عنوان ", value: "title", align: "center" },
        {
          text: "محتوی",
          value: "description",
          align: "center",
          sortable: false
        }
      ]
    };
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    search() {
      this.getByPagination();
    }
  },
  mounted() {
    this.getByPagination();
  },
  methods: {
    getByPagination() {
      this.loading = true;

      Api.getSetting({
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
    },

    save($item) {
      Api.update($item)
        .then(() => {
          this.snackColor = "success";
          this.snackText = this.$t("message.update.success");
          this.snack = true;
          //let self = this.editedIndex;
          //Object.assign(this.results[self], this.editedItem);
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.update.error");
        });
    },
    cancel() {
      this.snack = true;
      this.snackColor = "error";
      this.snackText = this.$t("message.snack.close");
    }
  }
};
</script>

<style scoped>
.headline {
  font-family: iranyekan !important;
}
</style>

