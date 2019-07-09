import axios from '../config/axios.js'

export default {
    getFilter(data) {
        return axios.post('user/filter', data)
    },
    getOrder(data) {
        return axios.post('user/order', data)
    },
    get(data) {
        return axios.post('user/index', data)
    },
    delete(id) {
        return axios.delete('user/delete/' + id)
    },
    update(data) {
        return axios.put('user/update', data)
    },
    create(data) {
        return axios.post('user/create', data)
    },
    changeState(id) {
        return axios.get('user/changeState/' + id)
    },
}
