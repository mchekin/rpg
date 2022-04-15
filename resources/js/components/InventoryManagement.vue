<template>
    <div>

        <div class="row">
            <popup-modal v-if="showModal" @closeModal="showModal = false">

                <div slot="body">

                    <div class="font-weight-bold">
                        {{ itemToDisplay.name }}

                        <button type="submit"
                                class="close"
                                @click.stop.prevent="showModal = false">
                            x
                        </button>
                    </div>

                    <div class="modal-item-price-image">
                        <img :src="'/' + itemToDisplay.image_file_path" :alt="itemToDisplay.name">
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
                                           v-model.number="itemToDisplay.price"
                                           @change.stop.prevent="changeItemPrice(itemToDisplay)"
                                           min="0"
                                           aria-label="Set item price">
                                </form>
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

        <div class="mx-1">
            <div class="row mx-1 table-dark align-items-center"
                 @drop="onDrop($event, 'equipment')"
                 @dragover.prevent
                 @dragenter.prevent>
                <div class="col-3 equipment-item">
                    {{ 'head_gear' | underscoreToWhitespace | capitalize }}
                    <button type="submit"
                            @click.stop.prevent="openItemModal(getEquipmentItem('head_gear'), 'equipment')"
                            @dragstart="startDrag($event, parseInt(getEquipmentItem('head_gear').pivot.inventory_slot_number), 'equipment')"
                            draggable="true"
                            class="btn btn-link-thin"
                            v-if="getEquipmentItem('head_gear')">
                        <img :src="asset(getEquipmentItem('head_gear').image_file_path)"
                             :alt="getEquipmentItem('head_gear').name">
                    </button>
                </div>
                <div class="col-3 equipment-item">
                    {{ 'body_armor' | underscoreToWhitespace | capitalize }}
                    <button type="submit"
                            @click.stop.prevent="openItemModal(getEquipmentItem('body_armor'), 'equipment')"
                            @dragstart="startDrag($event, parseInt(getEquipmentItem('body_armor').pivot.inventory_slot_number), 'equipment')"
                            draggable="true"
                            class="btn btn-link-thin"
                            v-if="getEquipmentItem('body_armor')">
                        <img :src="asset(getEquipmentItem('body_armor').image_file_path)"
                             :alt="getEquipmentItem('body_armor').name">
                    </button>
                </div>
                <div class="col-3 equipment-item">
                    {{ 'main_hand' | underscoreToWhitespace | capitalize }}
                    <button type="submit"
                            @click.stop.prevent="openItemModal(getEquipmentItem('main_hand'), 'equipment')"
                            @dragstart="startDrag($event, parseInt(getEquipmentItem('main_hand').pivot.inventory_slot_number), 'equipment')"
                            draggable="true"
                            class="btn btn-link-thin"
                            v-if="getEquipmentItem('main_hand')">
                        <img :src="asset(getEquipmentItem('main_hand').image_file_path)"
                             :alt="getEquipmentItem('main_hand').name">
                    </button>
                </div>
                <div class="col-3 equipment-item">
                    {{ 'off_hand' | underscoreToWhitespace | capitalize }}
                    <button type="submit"
                            @click.stop.prevent="openItemModal(getEquipmentItem('off_hand'), 'equipment')"
                            @dragstart="startDrag($event, parseInt(getEquipmentItem('off_hand').pivot.inventory_slot_number), 'equipment')"
                            draggable="true"
                            class="btn btn-link-thin"
                            v-if="getEquipmentItem('off_hand')">
                        <img :src="asset(getEquipmentItem('off_hand').image_file_path)"
                             :alt="getEquipmentItem('off_hand').name">
                    </button>
                </div>
            </div>
        </div>

        <div>
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
                            name: '',
                            effects: {
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
        equipItem(item) {

            if (!item) {
                return;
            }

            item.pivot.status = 'equipped';

            axios.post('/api/inventory/item/' + item.id + '/equip')
                .then(() => {
                    this.logSuccess('Equipped: ' + item.name);
                }).catch(error => {
                this.logError('Equipping item failed: ' + error.response.data.message);
            });
        },

        unEquipItem(item) {

            if (!item) {
                return;
            }

            item.pivot.status = 'in_backpack';

            axios.post('/api/inventory/item/' + item.id + '/un-equip')
                .then(() => {
                    this.logSuccess('Un-equipped: ' + item.name);
                }).catch(error => {
                this.logError('Un-equipping item failed: ' + error.response.data.message);
            });
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

        moveItemToStore(item) {

            if (!item) {
                return;
            }

            this.showModal = false;

            item.pivot.inventory_slot_number = this.findFreeStoreSlot();
            item.pivot.status = 'in_backpack';

            this.character.store.items.push(item);

            let index = this.character.inventory.items.indexOf(item);

            if (index > -1) {
                this.character.inventory.items.splice(index, 1);
            }

            axios.post('/api/inventory/item/' + item.id + '/move-to-store')
                .then(() => {
                    this.logSuccess('Moved: ' + item.name + ' to the store');

                    this.money_to_store = 0;
                }).catch(error => {
                this.logError('Moving item to the store failed: ' + error.response.data.message);
            });
        },

        moveItemToInventory(item) {

            if (!item) {
                return;
            }

            item.pivot.inventory_slot_number = this.findFreeInventorySlot();

            this.character.inventory.items.push(item);

            let index = this.character.store.items.indexOf(item);

            if (index > -1) {
                this.character.store.items.splice(index, 1);
            }

            axios.post('/api/store/item/' + item.id + '/move-to-inventory')
                .then(() => {
                    this.logSuccess('Moved: ' + item.name + ' to the inventory');

                    this.money_to_store = 0;
                }).catch(error => {
                this.logError('Moving item to the inventory failed: ' + error.response.data.message);
            });
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

        moveMoneyToInventory() {

            if (this.money_to_inventory === 0) {
                return;
            }

            this.character.inventory.money += this.money_to_inventory;
            this.character.store.money -= this.money_to_inventory;

            axios.post('/api/store/money/move-to-inventory', {'money_amount': this.money_to_inventory})
                .then(() => {
                    this.logSuccess('Moved: ' + this.money_to_store + ' coins to the inventory');

                    this.money_to_inventory = 0;
                }).catch(error => {
                this.logError('Moving coins to the store failed: ' + error.response.data.message);
            });
        },

        moveMoneyToStore() {

            if (this.money_to_store === 0) {
                return;
            }

            this.character.store.money += this.money_to_store;
            this.character.inventory.money -= this.money_to_store;

            axios.post('/api/inventory/money/move-to-store', {'money_amount': this.money_to_store})
                .then(() => {
                    this.logSuccess('Moved: ' + this.money_to_store + ' coins to the store');

                    this.money_to_store = 0;
                }).catch(error => {
                this.logError('Moving coins to the store failed: ' + error.response.data.message);
            });
        },

        asset(path) {
            let base_path = window._asset || '';

            return base_path + path;
        },

        getEquipmentItem(type) {
            return this.character.inventory.items.find(
                item => item.type === type && item.pivot.status === 'equipped'
            );
        },

        getInventoryItem(index) {
            return this.character.inventory.items.find(
                item => parseInt(item.pivot.inventory_slot_number) === parseInt(index)
            );
        },

        getStoreItem(index) {
            return this.character.store.items.find(
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

            let inventoryItem = this.getInventoryItem(itemIndex);

            if (container === 'equipment') {
                this.equipItem(inventoryItem);
            } else {
                this.unEquipItem(inventoryItem);
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
