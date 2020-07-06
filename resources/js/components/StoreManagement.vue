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
    </div>
</template>

<script>

    export default {
        mounted() {

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
                }
            }
        },

        created() {

            this.character = this.$attrs.character;
        },

        methods: {
            findFreeStoreSlot() {

                for (let slot = 0; slot < this.total_store_slots; slot++) {

                    if (this.getStoreItem(slot) === undefined) {
                        return slot;
                    }
                }

                return null;
            },

            findFreeInventorySlot() {

                for (let slot = 0; slot < this.total_inventory_slots; slot++) {

                    if (this.getInventoryItem(slot) === undefined) {
                        return slot;
                    }
                }

                return null;
            },

            moveToInventory(item) {

                if (item === null) {
                    return;
                }

                axios.post('/store/item/' + item.id + '/move-to-inventory')
                    .then(() => {

                        // debugger;
                        item.pivot.inventory_slot_number = this.findFreeInventorySlot();

                        this.character.inventory.items.push(item);

                        let index = this.character.store.items.indexOf(item);

                        if (index > -1) {
                            this.character.store.items.splice(index, 1);
                        }
                        // debugger;

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            moveToStore(item) {

                if (item === null) {
                    return;
                }

                axios.post('/inventory/item/' + item.id + '/move-to-store')
                    .then(() => {

                        // debugger;
                        item.pivot.inventory_slot_number = this.findFreeStoreSlot();
                        item.pivot.status = 'in_backpack';

                        this.character.store.items.push(item);

                        let index = this.character.inventory.items.indexOf(item);

                        if (index > -1) {
                            this.character.inventory.items.splice(index, 1);
                        }
                        // debugger;

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            asset(path) {
                let base_path = window._asset || '';

                return base_path + path;
            },

            getInventoryItem(index) {
                return this.character.inventory.items.find(
                    item => parseInt(item.pivot.inventory_slot_number) === index
                );
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
