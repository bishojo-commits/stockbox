<template>
    <div>
        <div class="container">
            <stock-statistics-component :stock="stock"></stock-statistics-component>
            <stock-chart-component :stock="stock" :depot="depot"></stock-chart-component>
        </div>
    </div>
</template>

<script>
    import StockChartComponent from "../components/StockChartComponent";
    import StockStatisticsComponent from "../components/StockStatisticsComponent";

    export default {
        components: {
            StockChartComponent,
            StockStatisticsComponent
        },

        props: {
            depot: Object,
            stock: Object
        }
    }
</script>
