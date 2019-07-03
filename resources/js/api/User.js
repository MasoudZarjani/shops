import axios from '../config/axios.js'

export default {
    get() {
        return axios.get('user')
    }
}