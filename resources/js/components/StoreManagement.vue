<template>

    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            <h5 class="text-center">
                {{ character.name }}'s Inventory
            </h5>

            <form role="form" method="POST">
                <!--{!! csrf_field() !!}-->
                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_inventory_slots"
                         :id="index-1"
                         :class="[isEquipped(index-1) ? 'inventory-item equipped' : 'inventory-item']">
                        <button type="submit" class="btn btn-link-thin" v-if="getInventoryItem(index-1)">
                            <img :src="asset(getInventoryItem(index-1).image_file_path)">
                        </button>
                    </div>

                </div>
            </form>

        </div>

        <!-- Right Side -->
        <div class="col-md-6">

            <h5 class="text-center">
                {{ character.name }}'s Store
            </h5>

            <form role="form" method="POST">
                <!--{!! csrf_field() !!}-->
                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_store_slots"
                         :id="index-1"
                         class="inventory-item">
                        <button type="submit" class="btn btn-link-thin" v-if="getStoreItem(index-1)">
                            <img :src="asset(getStoreItem(index-1).image_file_path)">
                        </button>
                    </div>

                </div>
            </form>

        </div>
        <!--<pre>{{ $data }}</pre>-->
    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                total_inventory_slots: 25,
                total_store_slots: 25,
                character: this.$attrs.character
            }
        },

        created() {
            console.log('created');

            // this.getCharacter();
        },

        methods: {

            getCharacter() {
                console.log('getCharacter');

                axios.get('/api/character')
                    .then(response => {
                        console.log(response);
                        this.character = response.data;
                    }).catch(error => {
                    console.log('error');
                    console.log(error.message);
                });
            },

            asset(path) {
                let base_path = window._asset || '';

                return base_path + path;
            },

            getInventoryItem(index) {
                return this.character.inventory.items.find(item => parseInt(item.pivot.inventory_slot_number) === index);
            },

            getStoreItem(index) {
                return this.character.store.items.find(item => parseInt(item.pivot.inventory_slot_number) === index);
            },

            isEquipped(index) {
                return this.getInventoryItem(index) && this.getInventoryItem(index).pivot.status === 'equipped';
            }
        }
    };
</script>

<style scoped>
</style>
