<template>
  <v-navigation-drawer
    app
    right
    v-model="drawer.open"
    :clipped="drawer.clipped"
    :fixed="drawer.fixed"
    :permanent="drawer.permanent"
    :mini-variant="drawer.mini"
    persistent
    elevation-10
    mobile-break-point="991"
    width="260"
  >
    <v-layout class="fill-height" tag="v-list" column>
      <v-toolbar flat class="transparent">
        <v-list>
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <v-img :src="logo" height="34" contain></v-img>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title class="title">{{ $t('navigation.title') }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-divider></v-divider>
      <v-list-tile
        v-for="(link, i) in links"
        :key="i"
        :to="link.to"
        avatar
        class="v-list-item"
      >
        <v-list-tile-action>
          <v-icon>{{ link.icon }}</v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="link.title"/>
      </v-list-tile>
    </v-layout>
  </v-navigation-drawer>
</template>

<script>
export default {
  props: ["drawer"],
  data: () => ({
    links: [
      { title: "صفحه اصلی", icon: "mdi-view-dashboard", to: "/" },
      { title: "کاربران", icon: "mdi-account-group", to: "/user" },
      { title: "تنظیمات", icon: "mdi-account-group", to: "/setting" },
    ],
    logo: "/images/vesam-logo.jpg"
  })
};
</script>

<style>
.title {
  font-family: iranyekan !important;
}
</style>

