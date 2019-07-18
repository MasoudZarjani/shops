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
    updateComment(data){
        return axios.get('comment/update'+ data)
    }
}
