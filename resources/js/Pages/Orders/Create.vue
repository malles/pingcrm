<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('orders')">
                Orders
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Nieuw
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-6xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <select-input v-model="form.park_id" :error="errors.park_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Park">
                        <option :value="null">Maak een keuze</option>
                        <option v-for="park in parks" :key="park.id" :value="park.id">
                            {{ park.name }}
                        </option>
                    </select-input>
                    <select-input v-model="form.supplier_id" :error="errors.supplier_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Leverancier">
                        <option :value="null">Maak een keuze</option>
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                            {{ supplier.name }}
                        </option>
                    </select-input>
                    <OrderProducts v-if="form.supplier_id" v-model="form.order_products"
                                   :products="supplierProducts"
                                   label="Produkten toevoegen"
                                   class="pr-6 pb-8 w-full"
                                   auto-add />
                    <div v-else class="pr-6 pb-8 w-full">
                        Kies eerst park en leverancier.
                    </div>
                    <text-input v-model="form.cost_price" :error="errors.cost_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="Inkoopprijs" />
                    <text-input v-model="form.selling_price" :error="errors.selling_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="Verkoopprijs" />
                    <text-input v-model="form.vat" :error="errors.vat"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="BTW" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">
                        Order aanmaken
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import SelectInput from '@/Shared/SelectInput';
import TextInput from '@/Shared/TextInput';
import OrderProducts from '@/Pages/Orders/OrderProducts';
import {orderProductsTotals,} from '@/Util';

export default {

    metaInfo: {title: 'Maak nieuwe order',},

    layout: Layout,

    components: {
        OrderProducts,
        LoadingButton,
        SelectInput,
        TextInput,
    },

    props: {
        errors: Object,
        parks: Array,
        suppliers: Array,
        products: Array,
    },

    remember: 'form',

    data() {
        return {
            sending: false,
            form: {
                park_id: null,
                supplier_id: null,
                cost_price: 0,
                selling_price: 0,
                vat: 0,
                order_products: [],
            },
        };
    },

    computed: {
        supplierProducts() {
            return this.form.supplier_id ? this.products.filter(p => p.supplier_id === this.form.supplier_id) : [];
        },
    },

    watch: {
        'form.order_products': {
            handler(orderProducts) {
                const {cost_price, selling_price,} = orderProductsTotals(orderProducts);
                this.form.cost_price = cost_price;
                this.form.selling_price = selling_price;
            },
            deep: true,
        },
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('orders.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
    },
};
</script>
