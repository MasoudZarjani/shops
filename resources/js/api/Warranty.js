import axios from '../config/axios.js'

export default {
    
    get(data) {
        return axios.post('warranty/index', data)
    },
    getOrder(data) {
        return axios.post('warranty/order', data)
    },
    getFilter(data) {
        return axios.post('warranty/filter', data)
    },
    delete(id) {
        return axios.delete('warranty/delete/' + id)
    },
    update(data) {
        return axios.put('warranty/update', data)
    },
    create(data) {
        return axios.post('warranty/create', data)
    },
    changeState(id) {
        return axios.get('warranty/changeState/' + id)
    }
}
