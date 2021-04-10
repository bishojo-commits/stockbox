<template>
    <div>
        <div v-if="isLoading">
            <vue-simple-spinner
                size="large"
                message="Loading Chart"
                line-fg-color="#957DAD"/>
        </div>
        <div class="container" v-if="data.labels.length > 0">
            <line-chart-component
                :data="data"
                :options="options">
            </line-chart-component>
        </div>
    </div>
</template>

<script>
import LineChartComponent from "../../charts/LineChartComponent";
import axios from 'axios'

export default {
    components: {
        LineChartComponent
    },

    props: {
        stocks: Array,
        depot: Object
    },

    data: () => ({
        isLoading: true,
        historical: [],
        depotTotalNow: [],
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Depot-Total',
                    backgroundColor: 'rgba(246, 109, 155, 0.2)',
                    data: []
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        callback: value => 'USD ' + value
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
            for (const [key, value] of Object.entries(this.depotTotalNow)) {
                this.data.labels.push(this.getDate(key));
                this.data.datasets[0].data.push(value);
            }
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
