import axios from '../config/axios.js'

export default {
    
    get(data) {
        return axios.post('category/index', data)
    },
    getOrder(data) {
        return axios.post('category/order', data)
    },
    delete(id) {
        return axios.delete('category/delete/' + id)
    },
    update(data) {
        return axios.put('category/update', data)
    },
    create(data) {
        return axios.post('category/create', data)
    }
}
