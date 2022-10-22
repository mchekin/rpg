<template>
    <div>

        <div class="row">
            <popup-modal v-if="showModal" @closeModal="showModal = false">

                <div slot="body">

                    <div class="font-weight-bold">

                        <button type="submit"
                                class="close"
                                @click.stop.prevent="showModal = false">
                            x
                        </button>

                        {{ itemToDisplay.name }}
                        <br>(
                            <small v-if="showContainer == 'inventory'">{{ customer.name }}'s Inventory</small>
                            <small v-else>{{ trader.name }}'s Store</small>
                        )
                    </div>

                    <div class="modal-item-price-image">
                        <img :src="'/' + itemToDisplay.image_file_path" :alt="itemToDisplay.name">
                    </div>

                    <table class="table model-item-attributes-table">
                        <caption class="caption-top">Attributes</caption>
                        <tr>
                            <th scope="row">Sell price</th>
                            <td v-if="showContainer == 'inventory'">
                                <form >
                                    <label for="set-item-price"></label>
                                    <input type="number"
                                           name="money_amount"
                                           id="set-item-price"
                                           class="w-100"
                                           v-model.number="itemToDisplay.price"
                                           @change.stop.prevent="changeItemPrice(itemToDisplay)"
                                           min="0"
                                           aria-label="Set item price">
                                </form>
                            </td>
                            <td v-else>
                                {{ itemToDisplay.price }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td>{{ itemToDisplay.type | underscoreToWhitespace | capitalize }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Effects</th>
                            <td>
                                <ul class="list-unstyled modal-item-effects">
                                    <li v-for="effect in itemToDisplay.effects" class="" :key="effect.type">
                                        {{ effect.type | capitalize }}: {{ effect.quantity | plusForPositiveNumber }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>

            </popup-modal>
        </div>

        <div class="row">

            <!-- Left Side -->
            <div class="col-md-6">

                <h5 class="text-center">
                    {{ customer.name }}'s Inventory
                </h5>

                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_inventory_slots" :key="index"
                         :id="index-1"
                         :class="[isEquipped(index-1) ? 'inventory-item equipped' : 'inventory-item']"
                         @drop="onDrop($event, 'inventory')"
                         @dragover.prevent
                         @dragenter.prevent>
                        <button type="submit"
                                @click.stop.prevent="openItemModal(getInventoryItem(index-1), 'inventory')"
                                @dragstart="startDrag($event, index-1, 'inventory')"
                                draggable="true"
                                class="btn btn-link-thin"
                                v-if="getInventoryItem(index-1)">
                            <img :src="asset(getInventoryItem(index-1).image_file_path)"
                                 :alt="getInventoryItem(index-1).name">
                        </button>
                    </div>

                </div>

            </div>

            <!-- Right Side -->
            <div class="col-md-6">

                <h5 class="text-center">
                    {{ trader.name }}'s Store ({{ trader.store.type | underscoreToWhitespace | capitalize }})
                </h5>

                <div class="my-3 row mx-1 table-dark align-items-center">

                    <div v-for="index in total_store_slots" :key="index"
                         :id="index-1"
                         class="inventory-item"
                         @drop="onDrop($event, 'store')"
                         @dragover.prevent
                         @dragenter.prevent>
                        <button type="submit"
                                @click.stop.prevent="openItemModal(getStoreItem(index-1), 'store')"
                                class="btn btn-link-thin"
                                @dragstart="startDrag($event, index-1, 'store')"
                                draggable="true"
                                v-if="getStoreItem(index-1)">
                            <img :src="asset(getStoreItem(index-1).image_file_path)" :alt="getStoreItem(index-1).name">
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
                                    Money in inventory: {{ customer.inventory.money }}
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
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold">
                                    Money in store: {{ trader.store.money }}
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
            itemToDisplay: {
                pivot: {
                    inventory_slot_number: null,
                    status: ''
                },
                image_file_path: '',
                price: 0,
                type: '',
                name: '',
                effects: {
                    quantity: 0,
                    type: ''
                }
            },
            showModal: false,
            showContainer: 'inventory',
            sourceContainer: 'inventory',
            money_to_store: 0,
            money_to_inventory: 0,
            total_inventory_slots: 25,
            total_store_slots: 25,
            customer: {
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
                            name: '',
                            effects: {
                                quantity: 0,
                                type: ''
                            }
                        }
                    ],
                    money: 0
                },
            },
            trader: {
                name: '',
                store: {
                    id: '',
                    items: [
                        {
                            pivot: {
                                inventory_slot_number: null,
                                status: ''
                            },
                            image_file_path: '',
                            price: 0,
                            type: '',
                            name: '',
                            effects: {
                                quantity: 0,
                                type: ''
                            }
                        }
                    ],
                    money: 0,
                    type: null
                }
            }
        }
    },

    created() {
        this.customer = this.$attrs.customer;
        this.trader = this.$attrs.trader;
    },

    methods: {

        buy(item) {

            if (!item) {
                this.logError('Item not found');

                return;
            }

            if (this.customer.inventory.money < item.price) {
                this.logError('You don\'t have ' + item.price + ' coins');

                return;
            }

            this.exchangeMoneyForItem(item);

            axios.post('/api/store/' + this.trader.store.id + '/item/' + item.id + '/buy')
                .then(() => {
                    this.logSuccess('Bought: ' + item.name + ' for ' + item.price + ' coins');
                }).catch(error => {
                this.exchangeItemForMoney(item);
                this.logError('Buying failed: ' + error.response.data.message);
            });
        },

        sell(item) {

            if (!item) {
                return;
            }

            if (this.trader.store.type === 'sell_only') {
                this.logError('This store only sell items - find a merchant store instead');

                return;
            }

            if (this.trader.store.money < item.price) {
                this.logError('The store doesn\'t have ' + item.price + ' coins');

                return;
            }


            this.exchangeItemForMoney(item);

            axios.post('/api/store/' + this.trader.store.id + '/item/' + item.id + '/sell')
                .then(() => {
                    this.logSuccess('Sold: ' + item.name + ' for ' + item.price + ' coins');
                }).catch(error => {
                this.exchangeMoneyForItem(item);
                this.logError(error.response.data.message);
            });
        },

        exchangeMoneyForItem: function (item) {
            item.pivot.inventory_slot_number = this.findFreeInventorySlot();

            this.customer.inventory.items.push(item);

            let index = this.trader.store.items.indexOf(item);

            if (index > -1) {
                this.trader.store.items.splice(index, 1);
            }

            this.customer.inventory.money -= item.price;
            this.trader.store.money += item.price
        },

        exchangeItemForMoney: function (item) {

            item.pivot.inventory_slot_number = this.findFreeStoreSlot();

            this.trader.store.items.push(item);

            let index = this.customer.inventory.items.indexOf(item);

            if (index > -1) {
                this.customer.inventory.items.splice(index, 1);
            }

            this.trader.store.money -= item.price;
            this.customer.inventory.money += item.price
        },

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

        openItemModal(item, container) {

            if (!item) {
                return;
            }

            this.itemToDisplay = item;
            this.showModal = true;
            this.showContainer = container;
        },

        changeItemPrice(item) {
            if (!item) {
                return;
            }

            let newPrice = item.price;

            axios.post('/api/store/item/' + item.id + '/change-price', {
                'price': newPrice,
                'containerType': this.showContainer
            })
                .then(() => {
                    this.logSuccess(item.name + ' price changed to ' + newPrice + ' coins');
                }).catch(error => {
                this.logError('Changing price failed: ' + error.response.data.message);
            });
        },

        asset(path) {
            let base_path = window._asset || '';

            return base_path + path;
        },

        getInventoryItem(index) {
            return this.customer.inventory.items.find(
                item => parseInt(item.pivot.inventory_slot_number) === parseInt(index)
            );
        },

        getStoreItem(index) {
            return this.trader.store.items.find(
                item => parseInt(item.pivot.inventory_slot_number) === parseInt(index)
            );
        },

        isEquipped(index) {
            return this.getInventoryItem(index) && this.getInventoryItem(index).pivot.status === 'equipped';
        },

        startDrag(evt, itemIndex, container) {
            evt.dataTransfer.dropEffect = 'move';
            evt.dataTransfer.effectAllowed = 'move';

            this.sourceContainer = container;

            evt.dataTransfer.setData('itemIndex', itemIndex);
        },

        onDrop(evt, container) {
            const itemIndex = evt.dataTransfer.getData('itemIndex');

            if (container === this.sourceContainer) {
                return;
            }

            if (container === 'store') {
                let inventoryItem = this.getInventoryItem(itemIndex);

                this.sell(inventoryItem);
            } else {

                let storeItem = this.getStoreItem(itemIndex);

                this.buy(storeItem);
            }
        },

        logSuccess(message) {
            this.$root.$emit('successHappened', message);
        },

        logError(error) {
            this.$root.$emit('errorHappened', error);
        },
    }
};
</script>

<style scoped>
.modal-item-price-image img {
    height: 210px;
    width: 100%;
    background-color: black;
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
