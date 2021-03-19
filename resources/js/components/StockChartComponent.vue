<template>
    <div>
        <line-stock-show :stock="stock" :depot="depot"></line-stock-show>
        <bar-stock-show :stock="stock" :depot="depot"></bar-stock-show>
        <pie-stock-show :stock="stock" :depot="depot"></pie-stock-show>
    </div>
</template>

<script>
    import LineStockShow from "./stock_show/LineStockShow";
    import BarStockShow from "./stock_show/BarStockShow";
    import PieStockShow from "./stock_show/PieStockShow";
    import axios from 'axios'

    export default {
        components: {
            BarStockShow,
            LineStockShow,
            PieStockShow
        },

        props: {
            depot: Object,
            stock: Object
        },

        data () {
            return {
                user: null,
                historical: null
            }
        },

        methods: {
            async getUser () {
                let response = await axios.get('/api/user');
                this.user = response.data
            },

            async getHistorical () {
                let response = await axios.get(`/depot/${this.depot.id}/stock/${this.stock.id}/historical`);
                this.historical = response.data
                this.isloading = false
            },
        },

        computed: {},

        mounted() {
            this.getUser()
            this.getHistorical()
        }
    }
</script>
