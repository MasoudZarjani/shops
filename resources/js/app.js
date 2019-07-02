require("./bootstrap");

window.Vue = require("vue");

import VueRouter from "vue-router";
import VueI18n from "vue-i18n";
import i18n from "./config/i18n";
import router from "./routes";
import App from './views/panel/Panel'

import './config'

Vue.config.productionTip = false;

Vue.use(VueI18n);
Vue.use(VueRouter);
moment.locale('fa');

const app = new Vue({
    el: "#app",
    i18n,
    router,
    render: h => h(App)
});
