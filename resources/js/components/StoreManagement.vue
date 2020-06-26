<template>

    <div class="row">
        <!--{{ character.inventory.items }}-->

        <!-- Left Side -->
        <div class="col-md-6">

            <h5 class="text-center">
                {{ character.name }}'s Inventory
            </h5>

            <!--<div v-for="item in character.inventory.items" v-bind:key="item.id">-->
                <!--{{ item }}-->
            <!--</div>-->

            <form role="form" method="POST">
                <!--{!! csrf_field() !!}-->
                <div class="my-3 row mx-1 table-dark align-items-center">
                    <!--@foreach(range(0, App\Modules\Equipment\Domain\Inventory::NUMBER_OF_SLOTS) as $slotNumber)-->
                    <!--@php-->
                    <!--$item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();-->
                    <!--$isHighlighted = isset($item) && $item->isEquipped() ? 'equipped' : '';-->
                    <!--@endphp-->

                    <!--<div class="inventory-item {{ $isHighlighted }}">-->
                        <!--@if($item)-->
                        <!--<button type="submit" class="btn btn-link-thin"-->
                                <!--formaction="{{ route('inventory.item.move-to-store', compact('item')) }}">-->
                            <!--<img src="{{ asset($item->image_file_path) }}">-->
                        <!--</button>-->
                        <!--@endif-->
                    <!--</div>-->

                    <div v-for="index in total_inventory_slots"
                         :id="index-1"
                         :class="[isEquipped(index-1) ? 'inventory-item equipped' : 'inventory-item']">
                        <button type="submit" class="btn btn-link-thin" v-if="getItem(index-1)">
                            <img :src="asset(getItem(index-1).image_file_path)">
                        </button>
                    </div>

                    <!--@endforeach-->
                </div>
            </form>

        </div>

        <!-- Right Side -->
        <div class="col-md-6">

            <!--@php-->
            <!--/** @var \App\Character $character */-->
            <!--/** @var \App\Item $item */-->
            <!--$items = $character->store->items;-->
            <!--@endphp-->

            <!--<h5 class="text-center">-->
                <!--{{ $character->getName() }}'s Store-->
            <!--</h5>-->

            <!--<form role="form" method="POST">-->
                <!--{!! csrf_field() !!}-->
                <!--<div class="my-3 row mx-1 table-dark align-items-center">-->
                    <!--@foreach(range(0, App\Modules\Trade\Domain\Store::NUMBER_OF_SLOTS) as $slotNumber)-->
                    <!--@php-->
                    <!--$item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();-->
                    <!--@endphp-->

                    <!--<div class="inventory-item">-->
                        <!--@if($item)-->
                        <!--<button type="submit" class="btn btn-link-thin"-->
                                <!--formaction="{{ route('store.item.move-to-inventory', compact('item')) }}">-->
                            <!--<img src="{{ asset($item->image_file_path) }}">-->
                        <!--</button>-->
                        <!--@endif-->
                    <!--</div>-->

                    <!--@endforeach-->
                <!--</div>-->
            <!--</form>-->

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

                        ]
                    },
                    store: {
                        items: [

                        ]
                    }
                }
            }
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

            getItem(index) {
                return this.character.inventory.items.find(item => parseInt(item.pivot.inventory_slot_number) === index);
            },

            isEquipped(index) {
                return this.getItem(index) && this.getItem(index).pivot.status === 'equipped';
            }
        }
    };
</script>

<style scoped>
</style>
