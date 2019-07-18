<template>
  <div>
    <v-data-table :headers="headers" :items="results" :loading="loading">
      <template v-slot:items="props">
        <td class="text-xs-center">{{ props.index+1 }}</td>
        <td class="text-xs-center" align-center justify-cente>
          <v-edit-dialog
            :return-value.sync="props.item.code"
            lazy
            large
            @save="save(props.item)"
            @cancel="cancel"
          >
            <td class="mt-4">{{ props.item.name }}</td>
            <td class="mt-4">{{ props.item.code }}</td>
            <td class="mt-4 input-group-addon color-picker-container">
              <span class="current-color" :style="'background-color: ' + props.item.code"></span>
            </td>
            <template v-slot:input>
              <chrome-picker v-model="props.item.code" />
              <v-text-field v-model="props.item.name" label="نام رنگ" single-line counter autofocus></v-text-field>
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
import { Chrome } from "vue-color";
import Api from "../../api/Setting.js";

export default {
  components: {
    "chrome-picker": Chrome
  },
  data() {
    return {
      loading: false,
      snack: false,
      snackColor: "",
      snackText: "",
      results: [],
      headers: [
        { text: "ردیف", value: "id", align: "center", sortable: false },
        { text: "رنگ", value: "name", align: "center" }
      ]
    };
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  mounted() {
    this.get();
  },
  methods: {
    get() {
      this.loading = true;
      Api.getColor()
        .then(res => {
          this.loading = false;
          this.results = res.data.data;
        })
        .catch(err => console.log(err.response.data))
        .finally(() => (this.loading = false));
    },
    save($item) {
      Api.updateColor($item)
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
<style>
.current-color {
  display: inline-block;
  width: 16px;
  height: 16px;
  background-color: #000;
  cursor: pointer;
  box-shadow: 1px 1px 1px #888888;
}
.v-menu__activator {
  display: block !important;
}
</style>
