import axios from '../config/axios.js'

export default {
    getFilter(data) {
        return axios.post('product/filter', data)
    },
    getOrder(data) {
        return axios.post('product/order', data)
    },
    get(data) {
        return axios.post('product/index', data)
    },
    delete(id) {
        return axios.delete('product/delete/' + id)
    },
    updateDetail(data) {
        return axios.put('product/updateDetail', data)
    },
    create(data) {
        return axios.post('product/create', data)
    },
    changeState(id) {
        return axios.get('product/changeState/' + id)
    },
    getDetail(id) {
        return axios.get('product/detail/' + id)
    },
    uploadMultiImages(list) {
        return axios.post('product/uploadMultiImages/' , list)
    },
    removeImage(id){
        return axios.get('product/removeImage/'+id);
    },
    addColor(color,id){
        return axios.get('product/addColor/' + color + '/' + id);
    },
}
