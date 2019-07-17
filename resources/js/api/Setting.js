import axios from '../config/axios'

export default {
    getSetting(data) {
        return axios.post('setting/index', data)
    },
    update(data) {
        return axios.put('setting/update', data)
    },
    getOrder(data) {
        return axios.post('setting/order', data)
    },


    getColor() {
        return axios.post('color/index')
    },
    updateColor(data) {
        return axios.put('color/update', data)
    },

    
    getComment(data) {
        return axios.post('setting/indexComment', data)
    },
    getOrderComment(data) {
        return axios.post('setting/orderComment', data)
    },
}
