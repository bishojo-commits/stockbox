<template>
    <div>
        <div v-if="isloading">
            <vue-simple-spinner
                size="small"
                message="Loading Chart"
                line-fg-color="#f66d9b"/>
        </div>
        <div class="container" v-if="data.datasets[0].data.length > 0">
            <bar-chart-component
                :data="data"
                :options="options">
            </bar-chart-component>
        </div>
    </div>
</template>

<script>
    import BarChartComponent from "../../charts/BarChartComponent";
    import Spinner from 'vue-simple-spinner';
    import axios from 'axios'

    export default {
        components: {
            BarChartComponent,
            Spinner
        },

        props: {
            depot: Object,
            stock: Object
        },

        data: () => ({
            isloading: true,
            user: null,
            historical: null,
            data: {
                labels: ['StockGesamtBuyWorth', 'StockGesamtDepotWorth'],
                datasets: [
                    {
                        label: ['StockGesamtBuyWorth', 'StockGesamtDepotWorth'],
                        backgroundColor: ['rgba(246, 109, 155, 0.2)', 'rgba(246, 109, 155, 0.4)'],
                        data: []
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback: value => '€' + value
                        }
                    }]
                }
            }
        }),

        methods: {
            async getUser () {
                let response = await axios.get('/api/user');
                this.user = response.data
            },

            async getHistorical () {
                let response = await axios.get(`/depot/${this.depot.id}/stock/${this.stock.id}/historical`);
                this.historical = response.data.data.historical
                this.setChartData()
                this.isloading = false
            },

            getDate (timestamp) {
                let date =  new Date(timestamp * 1000)
                return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
            },

            setChartData () {
                let buyPrice = this.stock.pivot.buy_price * this.stock.pivot.quantity
                let depotWorth =  this.historical[this.historical.length -1].close * this.stock.pivot.quantity
                this.data.datasets[0].data.push(buyPrice)
                this.data.datasets[0].data.push(depotWorth)
            },

        },

        computed: {},

        mounted() {
            this.getUser()
            this.getHistorical()
        }
    }
</script>
