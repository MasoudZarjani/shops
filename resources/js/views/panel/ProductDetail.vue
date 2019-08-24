<template v-slot:extension>
  <v-container>
    <v-card>
      <v-layout>
        <v-flex xs6 sm4 md4>
          <v-card-text  class="fill-height">
              
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
          </v-card-text>
        </v-flex>
        <v-flex xs6 sm8 md8>
          <v-card-text v-if="detailTab">
          
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12 >
                  <v-text-field v-model="data.title" label="عنوان*" ></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12 >
                  <v-text-field v-model="data.description" label="توضیحات*" ></v-text-field>
                </v-flex>
                <v-flex xs12 sm4 md4 >
                  <v-switch v-model="data.status" label="وضعیت" ></v-switch>
                </v-flex>
                <v-flex xs12 sm4 md4 >
                  <v-select  v-model="data.brand" :items="data.brandList" label="برند" ></v-select>
                </v-flex>
                <v-flex xs12 sm8 md8>
                  <input type="file" v-on:change="onFileChange" />
                </v-flex>
                <v-flex xs12 sm4 md4>
                  <img v-if="mainImage!==''" :src="mainImage" class="img-responsive" width="200"/>
                  <img v-else :src="data.mainImage" class="img-responsive"  width="200"/>
                </v-flex>
              </v-layout>
            </v-container>
            <small>* فیلدهای الزامی را مشخص می نماید.</small>
            <v-btn color="primary darken-1" flat @click="saveDetail(data)" >ذخیره</v-btn>
          </v-card-text>


          <v-card-text v-if="galleryTab">
            <div>
              <div class="form-group col-md-12">
                <label for="logo" class="control-label">اسلایدر</label>
                <br><br>
                <div class="col-md-12">
                  <input type="file" multiple="multiple" id="attachments" @change="uploadFieldChange">
                  <hr>
                  <div class="col-md-12">
                    <div class="attachment-holder animated fadeIn" v-cloak v-for="(item, key) in gallery"  v-bind:key="key"> 
                      <td>{{ item.id }}</td>
                      <img :src="item.path" class="img-responsive" width="100"/>
                      <v-icon small color="red" @click="deleteImage(item)" >mdi-delete</v-icon>
                    </div>
                              
                    <div class="attachment-holder animated fadeIn" v-cloak v-for="(attachment, key) in attachments"  v-bind:key="key">
                      <img  :src="newImages[key]" class="img-responsive" width="100"/>
                      
                      <span class="label label-primary">{{ attachment.name + ' (' + Number((attachment.size / 1024 / 1024).toFixed(1)) + 'MB)'}}</span> 
                      <v-icon small color="red" @click="removeImage(attachment)" >mdi-delete</v-icon>
                      <br/><br/>
                    </div>
                  </div>
                </div>
                <br><br>
                <button class="btn btn-primary" @click="submit(data)">Upload</button>
              </div>
            </div>
          </v-card-text>

          <v-card-text v-if="colorTab">
            <div>
              <div class="form-group col-md-12">
                <label for="logo" class="control-label">رنگ ها</label>
                <br>
                <div class="col-md-12">
                  <div class="attachment-holder animated fadeIn" v-cloak v-for="(item, key) in colors"  v-bind:key="key"> 
                      <span class="current-color" :style="'background-color: ' + item.code"></span>{{ item.name }}
                      <v-icon small color="red" @click="deleteColor(item)">mdi-delete</v-icon>
                  </div>

                  <v-select label="رنگ" :items="data.colorList" item-text="name" item-value="id" @change="setColor"></v-select>
                  <button class="btn btn-primary" @click="addColor(data.id)">افزودن</button>
                </div>
                
              </div>
            </div>
          </v-card-text>
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
import Api from "../../api/Product.js";

export default {
  data: () => ({
    gallery: [],
    colors: [],
    drawer: true,
    items: [
      { title: "جزئیات", name: "detailTab", icon: "mdi-clipboard-text" },
      { title: "گالری", name: "galleryTab", icon: "mdi-file-image" },
      { title: "رنگ", name: "colorTab", icon: "mdi-palette" },
      { title: "فروشنده", name: "sellerTab", icon: "mdi-shopping" },
    ],
    right: null,
    modal: false,
    dialog: false,
    detailTab: true,
    galleryTab: false,
    colorTab: false,
    sellerTab: false,
    selectedColor:0,
    attachments : [],
    mainImage: "",
    newImages : [],
    editedIndex: -1,
    editedItem: {
      title: "",
      description: "",
      status: 0,
      price : 0,
      discount : 0,
      brand : 0,
      mainImage : '',
      gallery : [],
      colors : [],
      newImages : [],
    },
    defaultItem: {
      title: "",
      description: "",
      status: 0,
      price : 0,
      discount : 0,
      brand : 0,
      mainImage : '',
      gallery:[],
      colors : [],
      newImages : [],
    },
    file: "",
    snack: false,
    snackColor: "",
    snackText: "",
    data: [],
  }),
  mounted() {
    this.getDetail();
  },
  watch: {
    dialog(val) {
      val || this.close();
    },

    reversedMessage: function(){
			return this.message.split('').reverse().join('')
		}
  },
  methods: {

    showTab(name) {
      this.detailTab = false;
      this.galleryTab = false;
      this.colorTab = false;
      switch (name) {
        case "detailTab": this.detailTab = true; break;
        case "galleryTab": this.galleryTab = true; break;
        case "colorTab": this.colorTab = true; break;
        default: break;
      }
    },
    getDetail() {
      this.snack = false;
      Api.getDetail(this.$route.params.id)
        .then(result => {
          this.data = result.data.data;
          this.gallery = result.data.data.gallery;
          this.colors = result.data.data.colors;
          console.log(this.gallery);
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

    saveDetail(item){
      this.editedIndex = item.id;
      this.editedItem = Object.assign({}, item);
      if(this.mainImage!='')
        this.editedItem.mainImage = this.mainImage;
        
      Api.updateDetail(this.editedItem)
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
        vm.mainImage = e.target.result;
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
    },
    removeImage(item){
      console.log(item);
      this.snack = false;
      Api.removeImage(item)
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

    getAttachmentSize() {
        this.upload_size = 0; // Reset to beginningƒ
        this.attachments.map((item) => { this.upload_size += parseInt(item.size); });
        
        this.upload_size = Number((this.upload_size).toFixed(1));
        this.$forceUpdate();
    },

    removeImage(attachment) {
        this.attachments.splice(this.attachments.indexOf(attachment), 1);
        this.getAttachmentSize();
    },
            // This function will be called every time you add a file
    uploadFieldChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
            return;
        for (var i = files.length - 1; i >= 0; i--) {
            this.attachments.push(files[i]);
            let reader = new FileReader();
            let vm = this;
            reader.onload = e => {
              vm.newImages.push(e.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
        // Reset the form to avoid copying these files multiple times into this.attachments
        document.getElementById("attachments").value = [];
    },

    submit(item) {
      this.editedIndex = item.id;
      this.editedItem = Object.assign({}, item);
      //this.editedItem.mainImage = this.mainImage;
      this.editedItem.newImages = this.newImages;
      Api.uploadMultiImages(this.editedItem)
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
    // We want to clear the FormData object on every upload so we can re-calculate new files again.
    // Keep in mind that we can delete files as well so in the future we will need to keep track of that as well
    resetData() {
        this.listImages = new FormData(); // Reset it completely
        this.attachments = [];
    },
    start() {
        console.log('Starting File Management Component');
    },


    deleteImage(item) {
      const index = this.gallery.indexOf(item);
      if (confirm("از حذف مطمئن هستید؟")) {
        Api.removeImage(item.id)
          .then(() => {
            this.gallery.splice(index, 1);
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
    addColor(itemId) {
      
        Api.addColor(this.selectedColor,itemId)
        .then(result => {
          console.log(this.colors);
          this.colors.push(result.data.data);
          //console.log(this.colors);
        })
        .catch(error => {
          this.snack = true;
          this.snackColor = "error";
          this.snackText = this.$t("message.userDetail.error");
        });

    },
    setColor(selectedColor)
    {
      this.selectedColor = selectedColor;
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

