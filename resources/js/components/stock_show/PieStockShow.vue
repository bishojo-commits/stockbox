<template>
    <div>
        <div v-if="isloading">
            <vue-simple-spinner
                size="small"
                message="Loading Chart"
                line-fg-color="#f66d9b"/>
        </div>
        <div class="container" v-if="data.labels.length > 0">
            <pie-chart-component
                :data="data"
                :options="options">
            </pie-chart-component>
        </div>
    </div>
</template>

<script>
    import PieChartComponent from "../../charts/PieChartComponent";
    import Spinner from 'vue-simple-spinner';
    import axios from 'axios'

    export default {
        components: {
            PieChartComponent,
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
                        label: 'this.stock.name',
                        backgroundColor: 'rgba(246, 109, 155, 0.2)',
                        data: [600, 800]
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
                this.historical = response.data
                this.setChartData()
                this.isloading = false
            },

            getDate (timestamp) {
                let date =  new Date(timestamp * 1000)
                return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
            },

            setChartData () {
                //ToDo get Historical for all Stocks in Depot (write API Endpoint)
                 //sum each (stock historical close * stock.pivot.quantity)
            }
        },

        computed: {},

        mounted() {
            this.getUser()
            this.getHistorical()
        }
    }
</script>
