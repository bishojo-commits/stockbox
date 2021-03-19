<template>
    <div class="container" v-if="statistics">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
            <h3 class="text-success"> {{ formatPrice(statistics.price['regularMarketPrice'].raw) }}
                <span class="text-danger text-sm-right"> {{ formatPrice(statistics.price['regularMarketChange'].raw) }} </span>
                <span class="text-danger text-sm-right"> {{ statistics.price['regularMarketChangePercent'].fmt }}</span>
            </h3>
        </div>

        <div class="row pt-2 pb-2">
                <SummaryComponent :stock="stock"></SummaryComponent>
            <div class="col-md-4">
                <financial-middle-component :statistics="statistics"
                                            :stock="stock"
                                            :currencySymbol="currencySymbol"></financial-middle-component>
                <financial-right-component :statistics="statistics" :stock="stock"></financial-right-component>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import SummaryComponent from "./stock_statistics/SummaryComponent";
    import FinancialMiddleComponent from "./stock_statistics/FinancialMiddleComponent";
    import FinancialRightComponent from "./stock_statistics/FinancialRightComponent";

    export default {
        components: {
            SummaryComponent,
            FinancialMiddleComponent,
            FinancialRightComponent
        },

        props: {
            stock: Object
        },

        data: () => ({
            isloading: true,
            user: null,
            statistics: null,
            currencySymbol: null
        }),

        methods: {
            async getStatistics () {
                let response = await axios.get(`/stock/${this.stock.id}/statistics`)
                this.statistics = response.data
                this.currencySymbol = response.data.price.currencySymbol
                this.isloading = false
            },

            formatPrice (number) {
                return number.toFixed(2) + this.currencySymbol
            }
        },

        computed: {},

        mounted() {
            this.getStatistics()
        }
    }
</script>
