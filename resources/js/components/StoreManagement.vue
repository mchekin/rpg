<template>

</template>

<script>

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {}
        },

        created() {
            console.log('created');

            this.getCharacter();
        },

        methods: {

            getCharacter() {
                console.log('getCharacter');

                axios.get('/api/character')
                    .then(response => {
                        console.log(response);
                    }).catch(error => {
                        console.log('error');
                        console.log(error.message);
                    });
            }
        }
    };
</script>

<style scoped>
</style>
