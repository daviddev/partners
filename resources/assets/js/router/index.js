import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Home from '../components/Home.vue'
import Offers from '../components/offers/Offers.vue'
import OffersCreate from '../components/offers/OffersCreate.vue'
import OffersEdit from '../components/offers/OffersEdit.vue'
import Referrals from '../components/referrals/Referrals.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/referrals', component: Referrals },
    // { path: '/offers', component: Offers },
    // { path: '/offers/create', component: OffersCreate },
    // { path: '/offers/:id/edit', component: OffersEdit, props: true },
]

const router = new VueRouter({
    routes,
	linkExactActiveClass: 'active'
 })

export default router
