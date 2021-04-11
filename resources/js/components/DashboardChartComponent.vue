<template>
    <div>
        <div v-if="depotTotal" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
            <div class="price-wrapper">
                <h3 class="text-success" style="display: inline">
                    {{ formatPrice (depotNow) }}
                </h3>
                <span class="text-sm-right" :class="[depotGrowthNumeric < 0 ? 'text-danger' : 'text-success']">
                    <span v-if="depotGrowthNumeric < 0"> - </span>
                    <span v-else> + </span>
                    {{ formatPrice (depotGrowthNumeric) }}
                </span>
                <span class="text-sm-right" :class="[depotGrowthNumeric < 0 ?  'text-danger' : 'text-success']">
                    (
                    <span v-if="depotGrowthNumeric < 0"> - </span>
                    <span v-else> + </span>
                    {{ formatPercentage(depotGrowthPercent) }}
                    )
                </span>
            </div>
        </div>
        <div class="container">
            <line-depot-show
                @onTotalCalculated="onTotalCalculated"
                :stocks="stocks"
                :depot="depot">
            </line-depot-show>
        </div>
    </div>
</template>

<script>
    import LineDepotShow from "./depot_show/LineDepotShow";

    export default {
        data () {
            return {
                depotTotal: null,
                depotStart: null,
                depotNow: null,
                depotGrowthNumeric: null,
                depotGrowthPercent: null,
            }
        },

        components: {
            LineDepotShow
        },

        props: {
            stocks: Array,
            depot: Object
        },

        methods: {
            onTotalCalculated(depotTotal) {
                this.depotTotal = depotTotal;

                const keys = Object.keys(this.depotTotal);
                const first = keys[0];
                const last = keys[keys.length-1];

                this.depotStart = this.depotTotal[first];
                this.depotNow = this.depotTotal[last];

                this.depotGrowthNumeric = this.depotNow - this.depotStart;
                this.depotGrowthPercent = this.depotStart / this.depotNow * 10;
            },

            formatPrice (number) {
                return number.toFixed(2) + 'USD';
            },

            formatPercentage (number) {
                return number.toFixed(2) + '%';
            }
        }
    }
</script>
