<template>
  <v-footer app>
    <v-flex py-3 :primary="!goDark" text-xs-center>
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
    year: new Date().getFullYear()
  })
};
</script>

