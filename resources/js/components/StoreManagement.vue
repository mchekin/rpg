<template>

</template>

<script>

    export const AccessToken = {
        get: {
            tokenType() {
                return localStorage.getItem('access_token_type');
            },
            accessToken() {
                return localStorage.getItem('access_token');
            }
        },

        set: {
            tokenType(token) {
                localStorage.setItem('access_token_type', token);
            },
            accessToken(token) {
                localStorage.setItem('access_token', token);
            }
        }
    };

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {}
        },

        created() {
            console.log('created');

            axios.interceptors.request.use(function (config) {

                config.headers.Authorization = AccessToken.get.tokenType() + ' ' + AccessToken.get.accessToken();

                return config;
            });

            this.login('mchekin@gmail.com', '1234');

            this.fetchStore();
        },

        methods: {
            login(username, password) {

                axios.post('/oauth/token', {
                        'grant_type': 'password',
                        'client_id': 2,
                        'client_secret': 'NeecQ5VWaEupJmwt0nJhJVzhim8Woe7LBL9q4nbL',
                        'username': username,
                        'password': password
                    })
                    .then(response => {
                        AccessToken.set.tokenType(response.data.token_type);
                        AccessToken.set.accessToken(response.data.access_token);

                    }).catch(error => {
                        console.log('error');
                        console.log(error.message);
                    });
            },

            fetchStore() {
                console.log('fetchStore');

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
