import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'

const options = {
	color: '#fff',
	failedColor: '#ff0000',
	thickness: '1px',
	transition: {
		speed: '0.2s',
		opacity: '0.6s',
		termination: 300
	}
}

Vue.use(VueProgressBar, options)
