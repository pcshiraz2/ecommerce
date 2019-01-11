<template>
    <div>
        <date-picker v-model="date"></date-picker>
    </div>
</template>

<script>
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    export default {
        name: "date-picker-component",
        data(){
            return {
                date: ''
            }
        },
        components: {
            datePicker: VuePersianDatetimePicker
        }
    }
</script>

<style scoped>

    .vpd-input-group input {
        display: table-cell;
        border: 1px solid #dadada;
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        line-height: 30px;
        padding: 0 10px;
    }

</style>