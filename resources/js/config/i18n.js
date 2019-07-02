import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

function loadLocaleMessages() {
    const locales = require.context('../locales', true, /[A-Za-z0-9-_,\s]+\.json$/i)
    const messages = {}
    locales.keys().forEach(key => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i)
        if (matched && matched.length > 1) {
            const locale = matched[1]
            messages[locale] = locales(key)
        }
    })
    return messages
}

const dateTimeFormats = {
    'en-US': {
        short: {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        },
        long: {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            weekday: 'short',
            hour: 'numeric',
            minute: 'numeric'
        }
    },
    'ar-QA': {
        short: {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        },
        long: {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            weekday: 'short',
            hour: 'numeric',
            minute: 'numeric',
            hour24: true
        }
    },
    'fa-FA': {
        short: {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        },
        long: {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            weekday: 'short',
            hour: 'numeric',
            minute: 'numeric',
            hour24: true
        }
    },
}

const numberFormats = {
    'en-US': {
        currency: {
            style: 'currency',
            currency: 'USD'
        }
    },
    'fa-FA': {
        currency: {
            style: 'currency',
            currency: 'IRR',
            currencyDisplay: 'symbol'
        }
    },
    'ar-QA': {
        currency: {
            style: 'currency',
            currency: 'QAR',
            currencyDisplay: 'symbol'
        }
    }
}

export default new VueI18n({
    locale: process.env.VUE_APP_I18N_LOCALE || 'fa',
    fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'fa',
    messages: loadLocaleMessages(),
    dateTimeFormats,
    numberFormats
})
