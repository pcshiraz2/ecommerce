<template>
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th v-for="head in heads" scope="col" class="text-center">{{ head.title }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td scope="row" class="text-center">1</td>
            <td scope="row" class="text-center">2</td>
            <td scope="row" class="text-center">3</td>
            <td scope="row" class="text-center">4</td>
            <td scope="row" class="text-center">5</td>
            <td scope="row" class="text-center">6</td>
        </tr>
        <tr>
            <td scope="row" class="text-center">1</td>
            <td scope="row" class="text-center">2</td>
            <td scope="row" class="text-center">3</td>
            <td scope="row" class="text-center">4</td>
            <td scope="row" class="text-center">5</td>
            <td scope="row" class="text-center">6</td>
        </tr>
        <tr>
            <td scope="row" class="text-center">1</td>
            <td scope="row" class="text-center">2</td>
            <td scope="row" class="text-center">3</td>
            <td scope="row" class="text-center">4</td>
            <td scope="row" class="text-center">5</td>
            <td scope="row" class="text-center">6</td>
        </tr>
        <tr>
            <td scope="row" class="text-center">1</td>
            <td scope="row" class="text-center">2</td>
            <td scope="row" class="text-center">3</td>
            <td scope="row" class="text-center">4</td>
            <td scope="row" class="text-center">5</td>
            <td scope="row" class="text-center">6</td>
        </tr>
        <tr>
            <td scope="row" class="text-center">1</td>
            <td scope="row" class="text-center">2</td>
            <td scope="row" class="text-center">3</td>
            <td scope="row" class="text-center">4</td>
            <td scope="row" class="text-center">5</td>
            <td scope="row" class="text-center">6</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['heads', 'webData', 'postData'],
        name: "table-component",
        data() {
            return {
                heads: [],
                items: []
            }
        },
        mounted() {
            var v = this;
            console.log("Done.");
        }
    }
</script>

<style scoped>

</style>