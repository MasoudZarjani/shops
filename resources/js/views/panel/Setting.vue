<template>
  <div>{{setting}}</div>
</template>

<script>
import Api from "../../api/Setting";

export default {
  data: () => ({
    setting: "asd"
  }),
  created() {
    this.getSetting();
  },
  methods: {
    getSetting() {
      Api.getSetting({
        message: "hello world"
      }).then(res => {
        this.setting = res.data;
      });
    }
  }
};
</script>
