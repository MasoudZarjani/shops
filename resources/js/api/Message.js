import axios from '../config/axios.js'

export default {
    getFilter(data) {
        return axios.post('message/filter', data)
    },
    getOrder(data) {
        return axios.post('message/order', data)
    },
    get(data) {
        return axios.post('message/index', data)
    },
    changeState(id) {
        return axios.get('message/changeState/' + id)
    },
    getDetail(id) {
        return axios.get('message/detail/' + id)
    },
    update(data){
        return axios.get('message/update'+ data)
    }
}
