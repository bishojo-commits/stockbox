<template>
    <div class="container" v-if="statistics">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
            <div class="price-wrapper">
                <h3 class="text-success" style="display: inline">
                    {{ formatPrice(statistics.price['regularMarketPrice'].raw) }}
                </h3>
                <span class="text-s-right" :class="[isNegativePrice ? 'text-danger' : 'text-success']">
                    <span v-if="isNegativePrice"> - </span>
                    <span v-else> + </span>
                    {{ formatPrice(statistics.price['regularMarketChange'].raw) }}
                </span>
                <span class="text-s-right" :class="[isNegativePercentage ?  'text-danger' : 'text-success']">
                    ({{ statistics.price['regularMarketChangePercent'].fmt }})
                </span>
            </div>
        </div>

        <div class="row pt-2 pb-2">
                <SummaryComponent :stock="stock"></SummaryComponent>
                <financial-middle-component :statistics="statistics"
                                            :stock="stock"
                                            :currencySymbol="currencySymbol">
                </financial-middle-component>
                <financial-right-component :statistics="statistics" :stock="stock"></financial-right-component>
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
            isLoading: true,
            user: null,
            statistics: null,
            currencySymbol: '',
            isNegativePrice: true,
            isNegativePercentage: true
        }),

        methods: {
            getStatistics () {
                return axios.get(`/stock/${this.stock.id}/statistics`)
            },

            setStatistics() {
                this.getStatistics().then((response) => {
                    this.statistics = response.data.data.statistics
                    this.currencySymbol = response.data.data.statistics.price['currencySymbol']
                    this.checkValueOfMarketChange()
                    this.isLoading = false
                })
            },

            formatPrice (number) {
                return number.toFixed(2) + this.currencySymbol
            },

            checkValueOfMarketChange () {
                if (this.statistics.price['regularMarketChange'].raw > 0) {
                    this.isNegativePrice = false;
                    this.isNegativePercentage = false;
                }
            }
        },

        mounted() {
            this.setStatistics()
        }
    }
</script>
