import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import Vue from 'vue'
import Vuetify from "vuetify";
import fa from "vuetify/es5/locale/fa";
import en from "vuetify/es5/locale/en";
import ar from "vuetify/es5/locale/ar";
import theme from './theme'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify, {
    customProperties: true,
    theme,
    lang: {
        locales: {
            fa,
            en,
            ar
        },
        current: "fa"
    },
    iconfont: "mdi",
    rtl: true
});
