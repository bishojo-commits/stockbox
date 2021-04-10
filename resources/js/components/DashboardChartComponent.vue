<template>
    <div class="container">
        <line-depot-show
            :stocks="stocks"
            :depot="depot">
        </line-depot-show>
    </div>
</template>

<script>
    import LineDepotShow from "./depot_show/LineDepotShow";

    export default {
        components: {
            LineDepotShow
        },

        props: {
            stocks: Array,
            depot: Object
        }

    }
</script>
