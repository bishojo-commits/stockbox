<template>
    <div>
        <line-stock-show :stock="stock" :depot="depot"></line-stock-show>
        <bar-stock-show :stock="stock" :depot="depot"></bar-stock-show>
    </div>
</template>

<script>
    import LineStockShow from "./stock_show/LineStockShow";
    import BarStockShow from "./stock_show/BarStockShow";
    import axios from 'axios'

    export default {
        components: {
            BarStockShow,
            LineStockShow
        },

        props: {
            depot: Object,
            stock: Object
        },

        data () {
            return {
                user: null
            }
        },

        methods: {
            async getUser () {
                let response = await axios.get('/api/user');
                this.user = response.data
            }
        },

        computed: {},

        mounted() {
            this.getUser()
        }
    }
</script>
