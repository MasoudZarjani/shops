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
    <v-list dense>
      <template v-for="item in items">
        <v-list-group
          v-if="item.children"
          :key="item.title"
          v-model="item.model"
          :prepend-icon="item.icon"
          :append-icon="item.arrow_icon_alt"
        >
          <template v-slot:activator>
            <v-list-tile>
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
          <v-list-tile v-for="(child, i) in item.children" :key="i" :to="child.to">
            <v-list-tile-action v-if="child.icon">
              <v-icon>{{ child.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ child.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list-group>
        <v-list-tile v-else :key="item.title" :to="item.to">
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  props: ["drawer"],
  data: () => ({
    items: [
      { title: "صفحه اصلی", icon: "mdi-view-dashboard", to: "/" },
      { title: "کاربران", icon: "mdi-account-group", to: "/user" },
      { title: "دسته بندی", icon: "mdi-sitemap", to: "/category" },
      { title: "برند", icon: "mdi-factory", to: "/brand" },
      { title: "گارانتی", icon: "mdi-security", to: "/warranty" },
       { title: "فروشنده", icon: "mdi-shopping", to: "/seller" },
      { title: "محصولات", icon: "mdi-package-variant-closed", to: "/product" },
      { title: "سفارشات", icon: "mdi-cart", to: "/cart" },
      {
        title: "پیام ها",
        icon: "mdi-message",
        arrow_icon: "mdi-chevron-up",
        arrow_icon_alt: "mdi-chevron-down",
        children: [
          { title: "نظرات", to: "/comment", icon: "mdi-message-text" },
          { title: "پرسش و پاسخ", to: "/discuss", icon: "mdi-forum" }
        ]
      },
      {
        title: "تنظیمات",
        icon: "mdi-settings",
        arrow_icon: "mdi-chevron-up",
        arrow_icon_alt: "mdi-chevron-down",
        children: [
          { title: "رنگ", to: "setting/color", icon: "mdi-palette" },
          { title: "اپلیکیشن",to: "setting/application",icon: "mdi-cellphone-settings-variant" },
          { title: "نظرات",to: "setting/comment",icon: "mdi-phone-settings" }
        ]
      }
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

