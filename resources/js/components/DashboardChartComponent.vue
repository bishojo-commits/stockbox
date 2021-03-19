<template>
    <div class="container">
        <p> {{ user }}</p>

        <p v-if="summary">
            {{ getMarketPrice }}
        </p>

        <p v-if="historical">
            {{ transferDate }}
        </p>

        <line-chart-component
            :data="data"
            :options="options">
        </line-chart-component>
    </div>
</template>

<script>
    import LineChartComponent from "../charts/LineChartComponent";
    import axios from 'axios'

    export default {
        components: {
            LineChartComponent
        },

        data: () => ({
            user: null,
            summary: null,
            historical: null,
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [
                    {
                        label: 'Depot Kaufwert',
                        backgroundColor: 'rgba(246, 109, 155, 0.2)',
                        data: [5000, 5000, 7700, 7700, 7700]
                    },
                    {
                        label: 'Depot IstWert',
                        backgroundColor: 'rgba(246, 109, 155, 0.4)',
                        data: [5000, 3500, 6200, 8000, 12000]
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

            async getSummary () {
                let response = await axios.get('/stock-summary');
                this.summary = response.data
            },

            async getHistorical() {
                let response = await axios.get('/stock-historical');
                this.historical = response.data
            }
        },

        computed: {
            getMarketPrice () {
                let prices = []
                this.summary.forEach((stock) => {
                    prices.push(stock.price.regularMarketPrice)
                })
                return prices
            },

            transferDate () {
                return new Date(this.historical[0].firstTradeDate * 1000);
            }
        },

        mounted() {
            this.getUser();
            this.getSummary();
            this.getHistorical();
        }
    }
</script>
