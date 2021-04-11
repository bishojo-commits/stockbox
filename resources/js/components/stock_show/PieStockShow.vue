<template>
    <div>
        <div v-if="isLoading">
            <vue-simple-spinner
                size="small"
                message="Loading Chart"
                line-fg-color="#957DAD"/>
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
            isLoading: true,
            user: null,
            historical: [],
            depotTotalNow: [],
            stockWorth: null,
            data: {
                labels: [],
                datasets: [
                    {
                        backgroundColor: ['rgba(246, 109, 155, 0.2)', 'rgba(210, 145, 188, 0.6)'],
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
                            callback: value => 'USD' + value
                        }
                    }]
                }
            }
        }),

        methods: {
            async getHistorical(depotId, stockId) {
                return axios.get(`/depot/${depotId}/stock/${stockId}/historical`);

            },

            setChartData () {
                this.stocks = this.depot.stocks;
                console.log(this.stocks);
                this.stocks.forEach(stock => {
                    this.getHistorical(this.depot.id, stock.id)
                        .then((response) => {
                            this.historical[stock.id] = (response.data.data.historical);
                        })
                        .finally(() => {
                            //format historical price of each stock with multiplication of stock quantity
                            this.setNewClosePrice(stock);
                            this.setDepotTotalData();
                            this.setDepotTotalToChart();

                            this.isLoading = false;
                        });
                });
            },

            setNewClosePrice(stock) {
                this.historical.forEach((value, index) => {
                    this.stocks.forEach(stock => {
                        if (index === this.stock.id) {
                            this.stockWorth =  this.historical[index][0].close * this.stock.pivot.quantity
                        }
                        if (index === stock.id) {
                            this.historical[index].forEach(element => {
                                element.close *= stock.pivot.quantity;
                            });
                        }
                    });
                });
            },

            setDepotTotalData() {
                this.historical.forEach((value) => {
                    value.forEach((element) => {
                        if (this.depotTotalNow.hasOwnProperty(element.date)) {
                            this.depotTotalNow[element.date] += element.close;
                        } else {
                            this.depotTotalNow[element.date] = element.close;
                        }
                    });
                });
            },

            setDepotTotalToChart() {
                var keys = Object.keys(this.depotTotalNow);
                var last = keys[keys.length-1];

                this.data.datasets[0].data.push(this.depotTotalNow[last]);
                this.data.datasets[0].data.push(this.stockWorth);

                this.data.labels.push('DepotTotal');
                this.data.labels.push(this.stock.name);

            },

            getDate (timestamp) {
                let date =  new Date(timestamp * 1000)
                return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
            },
        },

        mounted() {
            this.setChartData();
        }
    }
</script>
