import axios from '../config/axios.js'

export default {
    
    get(data) {
        return axios.post('brand/index', data)
    },
    getOrder(data) {
        return axios.post('brand/order', data)
    },
    getFilter(data) {
        return axios.post('brand/filter', data)
    },
    delete(id) {
        return axios.delete('brand/delete/' + id)
    },
    update(data) {
        return axios.put('brand/update', data)
    },
    create(data) {
        return axios.post('brand/create', data)
    },
    changeState(id) {
        return axios.get('brand/changeState/' + id)
    }
}
