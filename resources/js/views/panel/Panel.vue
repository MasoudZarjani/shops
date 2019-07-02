<template>
  <v-app :dark="goDark">
    <layout-drawer :drawer="drawer"></layout-drawer>
    <layout-toolbar :drawer="drawer" v-on:changeTheme="updateTheme($event)"></layout-toolbar>
    <layout-view></layout-view>
    <layout-footer :goDark="goDark"></layout-footer>
  </v-app>
</template>

<script>
export default {
  components: {
    LayoutDrawer: () => import("../../components/panel/layouts/Drawer"),
    LayoutFooter: () => import("../../components/panel/layouts/Footer"),
    LayoutToolbar: () => import("../../components/panel/layouts/Toolbar"),
    LayoutView: () => import("../../components/panel/layouts/View")
  },
  data: () => ({
    drawer: {
      open: true,
      clipped: false,
      fixed: false,
      permanent: false,
      mini: false
    },
    goDark: false
  }),
  methods: {
    updateTheme(item) {
      this.goDark = item;
    }
  }
};
</script>