<template>
  <div>{{user}}</div>
</template>

<script>
import Api from "../../api/User";

export default {
  data: () => ({
    user: "User"
  }),
  mounted() {
      this.getUser();
  },
  methods: {
    getUser() {
      Api.get().then(data => {
        this.user = data.data;
      });
    }
  }
};
</script>
