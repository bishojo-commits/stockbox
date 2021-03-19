<template>
    <div>
        <div class="col-md-4">
            <h5>Financial Statistics</h5>
            <div class="text-sm">
                ProfitMargin <span class="text-secondary">{{ statistics.defaultKeyStatistics.profitMargins.fmt }}</span><br>
                SharesOutstanding <span class="text-secondary">{{ statistics.defaultKeyStatistics.sharesOutstanding.fmt }}</span><br>
                BookValue <span class="text-secondary">{{ statistics.defaultKeyStatistics.bookValue.fmt }}</span><br>
                PriceToBook <span class="text-secondary">{{ statistics.defaultKeyStatistics.priceToBook.fmt }}</span><br>
                EnterpriseValue <span class="text-secondary">{{ statistics.defaultKeyStatistics.enterpriseValue.fmt }}</span><br>
                52WeeksHigh <span class="text-secondary">{{ statistics.summaryDetail['fiftyTwoWeekHigh'].raw }}</span><br>
                52WeekChange <span class="text-secondary">{{ statistics.defaultKeyStatistics['52WeekChange'].fmt }}</span><br>
                Börse <span class="text-secondary">{{ statistics.quoteData[stock.ticker_symbol].fullExchangeName }}</span><br>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            statistics: Object,
            stock: Object
        },

        data: () => ({
            isloading: true,
        }),
    }
</script>
