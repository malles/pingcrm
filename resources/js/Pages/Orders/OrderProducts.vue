<template>
    <div>
        <label v-if="label" class="form-label">{{ label }}:</label>
        <ToggleButton v-if="!autoAdd" v-model="showList"
                      class="mb-2 btn-gray">
            Produkt toevoegen
        </ToggleButton>
        <div v-if="showList || autoAdd" class="p-4 border rounded">
            <div class="max-w-xs">
                <input v-model="search" class="form-input text-sm"
                       autocomplete="off" type="text"
                       name="search" placeholder="Zoeken…" />
            </div>
            <ul class="mt-2">
                <li class="p-2 border-b flex justify-between flex-wrap">
                    <small class="flex-1">Naam</small>
                    <small class="w-32">Parkreferentie</small>
                    <small class="w-32">Leveranciersreferentie</small>
                    <span class="w-10"></span>
                </li>
            </ul>
            <ul class="overflow-y-auto h-40">
                <li v-for="product in filteredProducts" :key="product.id"
                    class="p-2 border-b flex justify-between flex-wrap hover:bg-gray-100 cursor-pointer"
                    @click="addProduct(product)">
                    <strong class="flex-1 truncate">{{ product.name }}</strong>
                    <span class="w-32">{{ product.park_reference }}</span>
                    <span class="w-32">{{ product.supplier_reference }}</span>
                    <span class="w-10 flex justify-center items-center">
                         <icon :icon="['far', 'chevron-right']" class="w-6 h-6 text-gray-400" />
                    </span>
                </li>
                <li v-if="!filteredProducts.length" class="p-2 text-center">
                    Geen produkten gevonden
                </li>
            </ul>
        </div>
        <div v-if="value.length" class="mt-4">
            <ul class="mt-2">
                <li class="p-2 border-b flex justify-between flex-wrap">
                    <small class="w-20">Aantal</small>
                    <small class="flex-1">Produkt</small>
                    <small class="w-32">Inkoopprijs</small>
                    <small class="w-32">Verkoopprijs</small>
                    <small class="w-32">BTW</small>
                    <span class="w-10"></span>
                </li>
                <li v-for="orderProduct in value" :key="orderProduct.id"
                    class="p-2 border-b flex justify-between flex-wrap">
                    <div class="w-20 pr-2">
                        <input v-model="orderProduct.quantity" type="number" class="form-input" />
                    </div>
                    <div class="flex-1 truncate">
                        <strong>{{ orderProduct.name }}</strong><br />
                        <small>Park: {{ orderProduct.park_reference }}</small><br />
                        <small>Lev.: {{ orderProduct.supplier_reference }}</small>
                    </div>
                    <div class="w-32 pr-2">
                        <input v-model="orderProduct.cost_price" type="number" class="form-input" step="0.01" />
                    </div>
                    <div class="w-32 pr-2">
                        <input v-model="orderProduct.selling_price" type="number" class="form-input" step="0.01" />
                    </div>
                    <div class="w-32 pr-2">
                        <input v-model="orderProduct.vat" type="number" class="form-input" step="0.01" />
                    </div>
                    <div class="w-10 flex justify-center items-center">
                        <a class="cursor-pointer" @click="removeProduct(orderProduct)">
                            <icon :icon="['far', 'trash-alt']" class="w-6 h-6 text-red-400" />
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import {arrayWithRemovedItem,} from '@/Util';
import ToggleButton from '@/Shared/ToggleButton';

export default {

    components: {ToggleButton,},

    props: {
        value: Array,
        products: Array,
        label: String,
        autoAdd: {type: Boolean, default: false,},
    },

    data: () => ({
        showList: false,
        search: '',
    }),

    computed: {
        filteredProducts() {
            const search = this.search.toLowerCase();
            return this.products.filter(p => {
                return (!search || p.name.toLowerCase().includes(search) ||
                    String(p.park_reference).toLowerCase().includes(search) ||
                    String(p.supplier_reference).toLowerCase().includes(search));
            });
        },
    },

    methods: {
        addProduct({id, name, cost_price, selling_price, park_reference, supplier_reference,}) {
            this.$emit('input', [...this.value, {
                name, cost_price, selling_price, park_reference, supplier_reference,
                product_id: id,
                quantity: 1,
                vat: 0,
            },]);
        },
        removeProduct(product) {
            this.$emit('input', arrayWithRemovedItem(this.value, this.value.indexOf(product)));
        },
    },
};
</script>
