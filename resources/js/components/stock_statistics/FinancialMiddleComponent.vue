<template>
    <div class="col-md-4">
        <h5>Financial Statistics</h5>
        <div class="text-sm">
            CloseDayBefore
            <span class="text-secondary">
                        {{ formatPrice(statistics.price['regularMarketPreviousClose'].raw) }}
            </span><br>
            200DaysAverage
            <span class="text-secondary">
                        {{ formatPrice(statistics.summaryDetail['twoHundredDayAverage'].raw) }}
            </span><br>
            50DaysAverage
            <span class="text-secondary">
                        {{ formatPrice(statistics.summaryDetail['fiftyDayAverage'].raw) }}
            </span><br>
            GrossProfits <span class="text-secondary">{{ statistics.financialData.grossProfits.fmt }}</span><br>
            CurrentRatio <span class="text-secondary">{{ statistics.financialData.currentRatio.raw }}</span><br>
            ReturnOnAssets <span class="text-secondary">{{ statistics.financialData.returnOnAssets.fmt }}</span><br>
            ReturnOnEquity <span class="text-secondary">{{ statistics.financialData.returnOnEquity.fmt }}</span><br>
            RevenueGrowth <span class="text-secondary">{{ statistics.financialData.revenueGrowth.fmt }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            currencySymbol: String,
            statistics: Object,
            stock: Object
        },

        data: () => ({
            isLoading: true
        }),

        methods: {
            formatPrice (number) {
                return number.toFixed(2) + this.currencySymbol
            }
        },
    }
</script>
