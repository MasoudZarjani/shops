<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="desserts"
    >
      <template v-slot:items="props">
        <td>{{ props.index+1 }}</td>
        <td>
          <v-edit-dialog
            :return-value.sync="props.item.title"
            lazy
            @save="save"
            @cancel="cancel"
            @open="open"
            @close="close"
          > {{ props.item.title }}
            <template v-slot:input>
              <v-text-field
                v-model="props.item.title"
                :rules="[max250chars]"
                label="Edit"
                single-line
                counter
              ></v-text-field>
            </template>
          </v-edit-dialog>
        </td>
        <td class="text-xs-right">
          <v-edit-dialog
            :return-value.sync="props.item.description"
            large
            lazy
            @save="save"
            @cancel="cancel"
            @open="open"
            @close="close"
          >
            <div>{{ props.item.description }}</div>
            <template v-slot:input>
              <div class="mt-3 title">Update description</div>
            </template>
            <template v-slot:input>
              <v-text-field
                v-model="props.item.description"
                :rules="[max2500chars]"
                label="Edit"
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
      <v-btn flat @click="snack = false">Close</v-btn>
    </v-snackbar>
  </div>
</template>
<script>
  import Api from "../../api/Setting.js";
  export default {
    data () {
      return {
        snack: false,
        snackColor: '',
        snackText: '',
        max25chars: v => v.length <= 25 || 'Input too long!',
        pagination: {},
        headers: [
          { text: "ردیف", value: "id", align: "center" },
          { text: "عنوان ", value: "title", align: "center", sortable: false },
          { text: "محتوی", value: "description", align: "center", sortable: false  },
        ],
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
      save () {
        Api.update(this.editedIndex)
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
      },
      cancel () {
        this.snack = true
        this.snackColor = 'error'
        this.snackText = 'Canceled'
      },
      open () {
        this.snack = true
        this.snackColor = 'info'
        this.snackText = 'Dialog opened'
      },
      close () {
        console.log('Dialog closed')
      }
    }
  }
</script>

<style scoped>
.headline {
  font-family: iranyekan !important;
}
</style>

