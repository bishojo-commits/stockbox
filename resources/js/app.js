/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\StockShowComponent.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('bar-chart-component', require('./charts/BarChartComponent').default);
Vue.component('dashboard-chart-component', require('./components/DashboardChartComponent').default);
Vue.component('financial-middle-component', require('./components/stock_statistics/FinancialMiddleComponent').default);
Vue.component('financial-right-component', require('./components/stock_statistics/FinancialRightComponent').default);
Vue.component('line-chart-component', require('./charts/LineChartComponent').default);
Vue.component('pie-chart-component', require('./charts/PieChartComponent').default);
Vue.component('stock-chart-component', require('./components/StockChartComponent').default);
Vue.component('statistics-component', require('./components/StockStatisticsComponent').default);
Vue.component('summary-component', require('./components/stock_statistics/SummaryComponent').default);
Vue.component('stock-show-component', require('./pages/StockShowComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**import VueChartkick from 'vue-chartkick';
import Chart from 'chart.js';

Vue.use(VueChartkick.use(Chart));
 */

import Chart from 'vue-chartjs';
Vue.use(Chart);

const app = new Vue({
    el: '#app'
});
