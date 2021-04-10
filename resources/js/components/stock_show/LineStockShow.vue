<template>
    <div>
        <div v-if="isLoading">
            <vue-simple-spinner
                size="huge"
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
    import Spinner from 'vue-simple-spinner';
    import axios from 'axios'

    export default {
        components: {
            LineChartComponent,
            Spinner
        },

        props: {
            depot: Object,
            stock: Object
        },

        data: () => ({
            isLoading: true,
            user: null,
            historical: null,
            data: {
                labels: [],
                datasets: [
                    {
                        label: '',
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
            async getUser () {
                let response = await axios.get('/api/user');
                this.user = response.data
            },

            async getHistorical () {
                let response = await axios.get(`/depot/${this.depot.id}/stock/${this.stock.id}/historical`);
                this.historical = response.data.data.historical
                this.setChartData()
                this.isLoading = false
            },

            getDate (timestamp) {
                let date =  new Date(timestamp * 1000)
                return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
            },

            setChartData () {
                this.historical.forEach(element => {
                    this.data.labels.push(this.getDate(element.date))
                    this.data.datasets[0].data.push(element.close)
                })

                this.data.datasets[0].label = this.stock.name;
                this.data.labels.reverse()
                this.data.datasets[0].data.reverse()
            }
        },

        computed: {},

        mounted() {
            this.getUser()
            this.getHistorical()
        }
    }
</script>
