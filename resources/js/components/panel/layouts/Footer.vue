<template>
  <v-footer app>
    <v-flex py-3 :class="color" text-xs-center>
      <span white--tex>
        Copyright &copy; {{ year }} —
        <strong>Vesam 24</strong>
      </span>
    </v-flex>
  </v-footer>
</template>
<script>
export default {
  props: ["goDark"],
  data: () => ({
    color: "gradiant",
    year: new Date().getFullYear()
  }),
  watch() {
    if (this.goDark == false) this.color = "gradiant";
    else this.color = "";
  }
};
</script>
<style>
.v-input__control {
  height: 100% !important;
}
.v-input__slot {
  height: 100% !important;
}
.gradiant {
  background-image: linear-gradient(to right, #135589, #33d0cd);
}
</style>

