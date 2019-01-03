<template>
    <div class="card card-default">
        <div class="card-header">{{title}}</div>
        <div class="list-group list-group-flush" v-if="items">
            <a class="list-group-item" v-for="item in items" v-bind:href="item.url">{{item.title}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "item-list-component",
        props: ['title', 'webAddress'],
        data() {
            return {
                items: null
            }
        },
        mounted() {
            var v = this;
            axios.get(v.webAddress).then(function (response) {
                v.items = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>
