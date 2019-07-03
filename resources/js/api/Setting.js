import axios from '../config/axios'

export default {
    getSetting(data) {
        return axios.post('setting', data)
    }
}
