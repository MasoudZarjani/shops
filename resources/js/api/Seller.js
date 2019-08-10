import axios from '../config/axios.js'

export default {
    
    get(data) {
        return axios.post('seller/index', data)
    },
    getOrder(data) {
        return axios.post('seller/order', data)
    },
    getFilter(data) {
        return axios.post('seller/filter', data)
    },
    delete(id) {
        return axios.delete('seller/delete/' + id)
    },
    update(data) {
        return axios.put('seller/update', data)
    },
    create(data) {
        return axios.post('seller/create', data)
    },
    changeState(id) {
        return axios.get('seller/changeState/' + id)
    }
}
