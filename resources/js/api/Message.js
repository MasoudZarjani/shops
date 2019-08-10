import axios from '../config/axios.js'

export default {
    getFilterComment(data) {
        return axios.post('comment/filter', data)
    },
    getOrderComment(data) {
        return axios.post('comment/order', data)
    },
    getComment(data) {
        return axios.post('comment/index', data)
    },
    changeStateComment(id) {
        return axios.get('comment/changeState/' + id)
    },
    getDetailComment(id) {
        return axios.get('comment/detail/' + id)
    },


    getFilterDiscuss(data) {
        return axios.post('discuss/filter', data)
    },
    getOrderDiscuss(data) {
        return axios.post('discuss/order', data)
    },
    getDiscuss(data) {
        return axios.post('discuss/index', data)
    },
    changeStateDiscuss(id) {
        return axios.get('discuss/changeState/' + id)
    },
    updateDiscuss(data){
        return axios.put('discuss/update', data)
    }
}
