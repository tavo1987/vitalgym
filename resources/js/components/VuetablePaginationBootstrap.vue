<template>
    <div class="text-center">
        <ul class="pagination">
            <li :class="{'disabled': isOnFirstPage}">
                <a href="" @click.prevent="loadPage('prev')">
                    <span>&laquo;</span>
                </a>
            </li>
            <template v-if="notEnoughPages">
                <li v-for="(n, index) in totalPage" :key="index" :class="{'active': isCurrentPage(n)}">
                    <a href="#" @click.prevent="loadPage(n)" v-html="n"></a>
                </li>
            </template>
            <template v-else>
                <li v-for="(n, index) in windowSize" :key="index" :class="{'active': isCurrentPage(windowStart+n-1)}">
                    <a href="#" @click.prevent="loadPage(windowStart+n-1)" v-html="windowStart+n-1"></a>
                </li>
            </template>
            <li :class="{'disabled': isOnLastPage}">
                <a href="#" @click.prevent="loadPage('next')">
                    <span>&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    import VuetablePaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin'
    export default {
        mixins: [VuetablePaginationMixin],
    }
</script>
