import axios from 'axios'
import app from '../../app'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content

axios.interceptors.request.use(config => {
	app.$Progress.start()
	return config
});

axios.interceptors.response.use(response => {
	app.$Progress.finish()
	return response
});

window.axios = axios
