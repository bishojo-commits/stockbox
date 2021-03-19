<template>
    <div>
        <h5>Financial Statistics</h5>
        <div class="text-sm">
            KursCloseVortag
            <span class="text-secondary">
                        {{ formatPrice(statistics.price['regularMarketPreviousClose'].raw) }}
                    </span><br>
            200TageDurchschnitt
            <span class="text-secondary">
                        {{ formatPrice(statistics.summaryDetail['twoHundredDayAverage'].raw) }}
                    </span><br>
            50TageDurchschnitt
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
            currenySymbol: String,
            statistics: Object,
            stock: Object
        },

        data: () => ({
            isloading: true,
        }),

        methods: {
            formatPrice (number) {
                return number.toFixed(2) + this.currencySymbol
            }
        },
    }
</script>
