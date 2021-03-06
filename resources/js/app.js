import Vue from 'vue';
import VueMeta from 'vue-meta';
import PortalVue from 'portal-vue';
import { InertiaApp, } from '@inertiajs/inertia-vue';
import { InertiaProgress, } from '@inertiajs/progress/src';
import './icons';

Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route, }, });
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueMeta);

Vue.filter('currency', value => Number(value).toLocaleString([], {
    style: 'currency',
    currency: 'EUR',
    currencyDisplay: 'symbol',
}))
Vue.filter('date', date => (new Date(date)).toLocaleDateString())
Vue.filter('datetime', date => (new Date(date)).toLocaleString())

InertiaProgress.init();

let app = document.getElementById('app');

new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - ACO` : 'ACO',
    },
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(app);
