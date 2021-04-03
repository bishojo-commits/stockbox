<template>
    <div class="col-md-4">
        <h5>Company Data</h5>
        <div class="text-sm" v-if="summary">
            Company Name <span class="text-secondary">{{ summary.quoteType.longName }}</span><br>
            Symbol <span class="text-secondary">{{ summary.quoteType.symbol }}</span><br>
            Sector <span class="text-secondary">{{ summary.summaryProfile.sector }}</span><br>
            Industry <span class="text-secondary">{{ summary.summaryProfile.industry }}</span><br>
            Employees <span class="text-secondary">{{ summary.summaryProfile.fullTimeEmployees }}</span><br>
            Address <span class="text-secondary">{{ summary.summaryProfile.address1 }}, {{ summary.summaryProfile.city }}, {{ summary.summaryProfile.country }}</span><br>
            Website <span class="text-secondary">{{ summary.summaryProfile.website }}</span><br>
            ExchangeTimeZone <span class="text-secondary">{{ summary.quoteType.exchangeTimezoneName }}</span><br>
    </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            stock: Object
        },

        data: () => ({
            isLoading: true,
            user: null,
            summary: null
        }),

        methods: {
            async getSummary () {
                let response = await axios.get(`/stock/${this.stock.id}/summary`);
                this.summary = response.data.data.summary
                this.isLoading = false
            },
        },

        computed: {},

        mounted() {
            this.getSummary()
        }
    }
</script>
