import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import boardroom from '../components/Boardrooms';
import reservation from '../components/reservation';


const routes = [
    { path: '/', component: boardroom },
    { path: '/reservation', component: reservation },
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router
