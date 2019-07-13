import axios from '../config/axios'

export default {
    getSetting(data) {
        return axios.post('setting', data)
    },
    delete(id) {
        return axios.delete('setting/delete/' + id)
    },
    update(data) {
        return axios.put('setting/update', data)
    },
    create(data) {
        return axios.post('setting/create', data)
    },
    getOrder(data) {
        return axios.post('setting/order', data)
    }
}
