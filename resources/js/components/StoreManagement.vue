<template>
    <div>

        <div class="row">
            <popup-modal v-if="showModal" @close="showModal = false">
                <!-- use the modal component, pass in the prop -->
                    <!--
                  you can use custom content here to overwrite
                  default content
                -->

                <div slot="content">

                    <div class="font-weight-bold">
                        Set item price
                    </div>

                    <div class="set-item-price-image">
                        <img :src="itemForSale.image_file_path">
                    </div>

                    <div class="set-item-price-input">
                        <label for="set-item-price"></label>
                        <input type="number"
                               name="money_amount"
                               id="set-item-price"
                               class="form-control"
                               v-model.number="itemForSale.price"
                               min="0"
                               aria-label="Set item price">
                    </div>

                    <div class="set-item-price-controls" role="toolbar">
                        <button type="submit" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Confirm
                        </button>
                    </div>

                </div>

            </popup-modal>
        </div>

        <div class="row">

            <!-- Left Side -->
            <div class="col-md-6">

                <h5 class="text-center">
                    {{ character.name }}'s Inventory
                </h5>

                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_inventory_slots"
                         :id="index-1"
                         :class="[isEquipped(index-1) ? 'inventory-item equipped' : 'inventory-item']">
                        <button type="submit"
                                @click.stop.prevent="moveItemToStore(getInventoryItem(index-1))"
                                class="btn btn-link-thin"
                                v-if="getInventoryItem(index-1)">
                            <img :src="asset(getInventoryItem(index-1).image_file_path)">
                        </button>
                    </div>

                </div>

            </div>

            <!-- Right Side -->
            <div class="col-md-6">

                <h5 class="text-center">
                    {{ character.name }}'s Store
                </h5>

                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_store_slots"
                         :id="index-1"
                         class="inventory-item">
                        <button type="submit"
                                @click.stop.prevent="moveItemToInventory(getStoreItem(index-1))"
                                class="btn btn-link-thin"
                                v-if="getStoreItem(index-1)">
                            <img :src="asset(getStoreItem(index-1).image_file_path)">
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">

            <!-- Left Side -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 text-center my-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold">
                                    Money in inventory: {{ character.inventory.money }}
                                </span>
                            </div>
                            <label for="money-to-store"></label>
                            <input type="number"
                                   name="money_amount"
                                   id="money-to-store"
                                   class="form-control"
                                   v-model.number="money_to_store"
                                   min="0"
                                   :max=character.inventory.money
                                   aria-label="Money to move to store">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <button type="submit"
                                            class="btn btn-sm btn-secondary"
                                            @click.stop.prevent="moveMoneyToStore()">
                                        Move to Store
                                         <span class="fas fa-long-arrow-alt-right"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 text-center my-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <button type="submit"
                                            class="btn btn-sm btn-secondary"
                                            @click.stop.prevent="moveMoneyToInventory()">
                                        <span class="fas fa-long-arrow-alt-left"></span>
                                        Move to Inventory
                                    </button>
                                </span>
                            </div>
                            <label for="money-to-inventory"></label>
                            <input type="number"
                                   name="money_amount"
                                   id="money-to-inventory"
                                   class="form-control"
                                   v-model.number="money_to_inventory"
                                   min="0"
                                   :max=character.store.money
                                   aria-label="Money to move to inventory">
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold">
                                    Money in store: {{ character.store.money }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>

    export default {
        mounted() {

        },

        data() {
            return {
                itemForSale: {
                    pivot: {
                        inventory_slot_number: null,
                        status: ''
                    },
                    image_file_path: '',
                    price: 0
                },
                showModal: false,
                money_to_store: 0,
                money_to_inventory: 0,
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
                                image_file_path: '',
                                price: 0
                            }
                        ],
                        money: 0
                    },
                    store: {
                        items: [
                            {
                                pivot: {
                                    inventory_slot_number: null,
                                    status: ''
                                },
                                image_file_path: '',
                                price: 0
                            }
                        ],
                        money: 0
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

            moveItemToInventory(item) {

                if (item === null) {
                    return;
                }

                axios.post('/api/store/item/' + item.id + '/move-to-inventory')
                    .then(() => {

                        item.pivot.inventory_slot_number = this.findFreeInventorySlot();

                        this.character.inventory.items.push(item);

                        let index = this.character.store.items.indexOf(item);

                        if (index > -1) {
                            this.character.store.items.splice(index, 1);
                        }

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            moveItemToStore(item) {

                if (item === null) {
                    return;
                }

                this.itemForSale = item;
                this.showModal = true;

                axios.post('/api/inventory/item/' + item.id + '/move-to-store')
                    .then(() => {

                        item.pivot.inventory_slot_number = this.findFreeStoreSlot();
                        item.pivot.status = 'in_backpack';

                        this.character.store.items.push(item);

                        let index = this.character.inventory.items.indexOf(item);

                        if (index > -1) {
                            this.character.inventory.items.splice(index, 1);
                        }

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            moveMoneyToInventory() {

                if (this.money_to_inventory === 0) {
                    return;
                }

                axios.post('/api/store/money/move-to-inventory', {'money_amount': this.money_to_inventory})
                    .then(() => {

                        this.character.inventory.money += this.money_to_inventory;
                        this.character.store.money -= this.money_to_inventory;

                        this.money_to_inventory = 0;

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            moveMoneyToStore() {

                if (this.money_to_store === 0) {
                    return;
                }

                axios.post('/api/inventory/money/move-to-store', {'money_amount': this.money_to_store})
                    .then(() => {

                        this.character.store.money += this.money_to_store;
                        this.character.inventory.money -= this.money_to_store;

                        this.money_to_store = 0;

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
    .set-item-price-image img {
        height: 240px;
        width: 100%;
        background-color: black;
    }
    .set-item-price-input {
    }
    .set-item-price-controls {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-around;
        margin-top: 15px;
    }
</style>
