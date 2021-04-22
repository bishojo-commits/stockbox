<template>
    <div>
        <div v-if="isLoading && stocks.length > 0">
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
        historical: {},
        depotTotalNow: {},
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
        setChartData() {
            Promise.all(this.stocks.map(async (stock) => {
                await this.setHistorical(stock);
            })).finally(() => {
                this.setNewClosePrice();
                this.setDepotTotalData();
                this.setDepotTotalToChart();
            });
        },

        async setHistorical(stock) {
            const response = await axios.get(`/depot/${this.depot.id}/stock/${stock.id}/historical`);
            this.historical[stock.id] = response.data.data.historical;
        },

        setNewClosePrice() {
            for (const [key, value] of Object.entries(this.historical)) {
                this.stocks.forEach(stock => {
                    if (parseInt(key) === stock.id) {
                        value.forEach(element => {
                            element.close *= stock.pivot.quantity;
                        });
                    }
                });
            }
        },

        setDepotTotalData() {
            for (const [key, value] of Object.entries(this.historical)) {
                value.forEach((element) => {
                    const date = this.getDate(element.date);
                    if (this.depotTotalNow.hasOwnProperty(date)) {
                        this.depotTotalNow[date] += element.close;
                    } else {
                        this.depotTotalNow[date] = element.close;
                    }
                });
            }

            this.$emit('onTotalCalculated', this.depotTotalNow);
        },

        setDepotTotalToChart() {
            for (const [key, value] of Object.entries(this.depotTotalNow)) {
                this.data.labels.push(key);
                this.data.datasets[0].data.push(value);
            }

            this.data.labels.reverse();
            this.data.datasets[0].data.reverse();

            this.isLoading = false;
        },

        getDate (timestamp) {
            let date =  new Date(timestamp * 1000)
            return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
        }
    },

    mounted() {
        this.setChartData();
    }
}
</script>
