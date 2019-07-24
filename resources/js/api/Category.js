import axios from '../config/axios.js'

export default {
    
    get(data) {
        return axios.post('category/index', data)
    },
    getOrder(data) {
        return axios.post('category/order', data)
    },
    getFilter(data) {
        return axios.post('category/filter', data)
    },
    delete(id) {
        return axios.delete('category/delete/' + id)
    },
    update(data) {
        return axios.put('category/update', data)
    },
    create(data) {
        return axios.post('category/create', data)
    },
    changeState(id) {
        return axios.get('category/changeState/' + id)
    },

    getComments(id) {
        return axios.get('category/getComments/'+ id)
    },
    createComment(data) {
        return axios.post('category/createComment', data)
    },
    updateComment(data) {
        return axios.put('category/updateComment', data)
    },
    deleteComment(id) {
        return axios.delete('category/deleteComment/' + id)
    },


    getSpecifications(id) {
        return axios.get('category/getSpecifications/'+ id)
    },
    createSpecification(data) {
        return axios.post('category/createSpecification', data)
    },
    updateSpecification(data) {
        return axios.put('category/updateSpecification', data)
    },
    deleteSpecification(id) {
        return axios.delete('category/deleteSpecification/' + id)
    },
}
