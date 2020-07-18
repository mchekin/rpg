<template>
    <div>

        <div class="row">
            <popup-modal v-if="showModal">

                <div slot="content">
                    <div class="font-weight-bold">
                        {{ itemForSale.name }}
                    </div>

                    <div class="modal-item-price-image">
                        <img :src="itemForSale.image_file_path">
                    </div>

                    <table class="table model-item-attributes-table">
                        <caption class="caption-top">Attributes</caption>
                        <tr>
                            <th scope="row">Sell price</th>
                            <td>
                                <form>
                                    <label for="set-item-price"></label>
                                    <input type="number"
                                           name="money_amount"
                                           id="set-item-price"
                                           class="w-100"
                                           v-model.number="itemForSale.price"
                                           @change.stop.prevent="changeItemPrice(itemForSale)"
                                           min="0"
                                           aria-label="Set item price">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td>{{ itemForSale.type | underscoreToWhitespace | capitalize }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Effects</th>
                            <td>
                                <ul class="list-unstyled modal-item-effects">
                                    <li v-for="effect in itemForSale.effects" class="">
                                        {{ effect.type | capitalize }}: {{ effect.quantity | plusForPositiveNumber }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <div class="modal-item-price-controls" role="toolbar">
                        <button type="submit"
                                class="btn btn-secondary"
                                @click.stop.prevent="showModal = false">
                            Close
                        </button>
                        <button type="submit"
                                class="btn btn-sm btn-primary"
                                @click.stop.prevent="moveItemToStore(itemForSale)">
                            Move to store
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
                                @click.stop.prevent="openItemModal(getInventoryItem(index-1))"
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
                    price: 0,
                    type: '',
                    effects : {
                        quantity: 0,
                        type: ''
                    }
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
                                price: 0,
                                type: '',
                                effects : {
                                    quantity: 0,
                                    type: ''
                                }
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
                                price: 0,
                                type: '',
                                effects : {
                                    quantity: 0,
                                    type: ''
                                }
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

            openItemModal(item) {

                if (item === null) {
                    return;
                }

                this.itemForSale = item;
                this.showModal = true;
            },

            changeItemPrice(item) {

                if (item === null) {
                    return;
                }

                axios.post('/api/inventory/item/' + item.id + '/change-price', {'price': item.price})
                    .then(() => {

                    }).catch(error => {
                    console.log(error.message);
                });
            },

            moveItemToStore(item) {

                if (item === null) {
                    return;
                }

                this.showModal = false;

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
    .modal-item-price-image img {
        height: 240px;
        width: 100%;
        background-color: black;
    }

    .modal-item-price-controls {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-around;
        margin-top: 15px;
    }

    .modal-item-effects {
        vertical-align: middle;
        margin: 0;
    }

    .model-item-attributes-table th, .model-item-attributes-table td {
        vertical-align: middle;
        font-size: small;
        white-space: nowrap;
    }
</style>
