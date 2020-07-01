<template>

    <div class="row" v-bind="character">

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
                        <button @click.stop.prevent="moveToStore(getInventoryItem(index-1))"
                                class="btn btn-link-thin"
                                v-bind="getInventoryItem(index-1)"
                                v-if="getInventoryItem(index-1)">
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
                        <button type="submit"
                                @click.stop.prevent="moveToInventory(getStoreItem(index-1))"
                                class="btn btn-link-thin"
                                v-if="getStoreItem(index-1)">
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
                character: {
                    name: '',
                    inventory: {
                        items: [
                            {
                                pivot: {
                                    inventory_slot_number: null,
                                    status: ''
                                },
                                image_file_path: ''
                            }
                        ]
                    },
                    store: {
                        items: [
                            {
                                pivot: {
                                    inventory_slot_number: null,
                                    status: ''
                                },
                                image_file_path: ''
                            }
                        ]
                    }
                },
                renderKey: 0
            }
        },

        created() {
            console.log('created');

            this.character = this.$attrs.character;

            // this.getCharacter();
        },

        methods: {

            forceRerender() {
                this.renderKey += 1;
            },

            findFreeInventorySlot() {

                for (let slot in this.total_inventory_slots) {

                    if (this.getInventoryItem(slot) === null) {
                        return slot;
                    }
                }

                return null;
            },

            moveToInventory(item) {
                console.log('moveToInventory');

                if (item === null) {
                    return;
                }

                axios.post('/store/item/' + item.id + '/move-to-inventory')
                    .then(response => {
                        console.log(response);

                        item.pivot.inventory_slot_number = this.findFreeInventorySlot();

                        this.character.inventory.items.push(item);

                        this.forceRerender();

                    }).catch(error => {
                    console.log('error');
                    console.log(error.message);
                });
            },

            moveToStore(item) {
                console.log('moveToStore');

                if (item === null) {
                    return;
                }

                axios.post('/inventory/item/' + item.id + '/move-to-store')
                    .then(response => {
                        console.log(response);
                    }).catch(error => {
                    console.log('error');
                    console.log(error.message);
                });
            },

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
