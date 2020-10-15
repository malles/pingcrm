<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('orders')">
                Orders
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.reference }}
        </h1>
        <trashed-message v-if="order.deleted_at" class="mb-6" @restore="restore">
            Deze order is verwijderd.
        </trashed-message>
        <div class="-mr-6 -mb-8 flex flex-wrap">
            <div class="pr-6 pb-8 lg:flex-1">
                <div class="bg-white rounded shadow overflow-hidden">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input v-model="form.reference" :error="errors.reference" class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="ACO ordernummer" />
                            <text-input v-model="form.park_reference" :error="errors.park_reference"
                                        class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="Park ordernummer" />
                            <text-input v-model="form.ordered_at" :error="errors.ordered_at"
                                        type="date" class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="Datum" />
                            <select-input v-model="form.park_id" :error="errors.park_id"
                                          class="pr-6 pb-8 w-full lg:w-1/2" label="Park">
                                <option v-for="park in parks" :key="park.id" :value="park.id">
                                    {{ park.name }}
                                </option>
                            </select-input>
                            <select-input v-model="form.supplier_id" :error="errors.supplier_id"
                                          class="pr-6 pb-8 w-full lg:w-1/2" label="Leverancier">
                                <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                    {{ supplier.name }}
                                </option>
                            </select-input>
                            <OrderProducts v-model="form.order_products"
                                           :products="supplierProducts"
                                           label="Produkten"
                                           class="pr-6 pb-8 w-full" />
                            <div class="pr-6 pb-8 grid grid-cols-4 gap-4 w-full">
                                <div class="col-span-3 flex items-center justify-end">Vrachtkosten:</div>
                                <div>
                                    <text-input v-model="form.carriage_price" :error="errors.carriage_price"
                                                type="number" step="0.01"
                                                class="w-full"/>
                                </div>
                            </div>
                            <OrderTotals :order="form" />
                            <hr class="my-4 mr-6 border-t w-full" />
                            <text-input v-model="form.invoiced_at" :error="errors.invoiced_at"
                                        type="date" class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="Gefactureerd op" />
                            <text-input v-model="form.internal_invoice_id" :error="errors.internal_invoice_id"
                                        class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="Intern factuurnummer" />
                            <text-input v-model="form.external_invoice_id" :error="errors.external_invoice_id"
                                        class="pr-6 pb-8 w-full lg:w-1/3"
                                        label="Extern factuurnummer" />
                            <textarea-input v-model="form.notes" :error="errors.notes" class="pr-6 pb-8 w-full"
                                            label="Notities" />
                        </div>
                        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                            <button v-if="!order.deleted_at" class="text-red-600 hover:underline" tabindex="-1"
                                    type="button"
                                    @click="destroy">
                                Verwijder order
                            </button>
                            <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">
                                Order opslaan
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pr-6 pb-8 flex-1 lg:flex-none lg:w-1/4 xl:w-1/3">
                <div class="bg-gray-100 w-full rounded shadow p-8">
                    things
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import SelectInput from '@/Shared/SelectInput';
import TextInput from '@/Shared/TextInput';
import TrashedMessage from '@/Shared/TrashedMessage';
import TextareaInput from '@/Shared/TextareaInput';
import OrderTotals from '@/Pages/Orders/OrderTotals';
import OrderProducts from '@/Pages/Orders/OrderProducts';
import {orderProductsTotals,} from '@/Util';

export default {

    metaInfo() {
        return {
            title: this.form.name,
        };
    },
    layout: Layout,

    components: {
        OrderTotals,
        OrderProducts,
        LoadingButton,
        SelectInput,
        TextInput,
        TextareaInput,
        TrashedMessage,
    },

    props: {
        errors: Object,
        order: Object,
        parks: Array,
        suppliers: Array,
        products: Array,
    },

    remember: 'form',

    data() {
        return {
            sending: false,
            form: {
                ordered_at: moment(this.order.ordered_at).format('YYYY-MM-DD'),
                park_reference: this.order.park_reference,
                reference: this.order.reference,
                park_id: this.order.park_id,
                supplier_id: this.order.supplier_id,
                internal_invoice_id: this.order.internal_invoice_id,
                external_invoice_id: this.order.external_invoice_id,
                cost_price: this.order.cost_price,
                carriage_price: this.order.carriage_price || 0,
                selling_price: this.order.selling_price,
                vat: this.order.vat,
                invoiced_at: this.order.invoiced_at ? moment(this.order.invoiced_at).format('YYYY-MM-DD') : null,
                notes: this.order.notes,
                order_products: this.order.order_products || [],
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
            handler() {
                this.setTotals();
            },
            deep: true,
        },
        'form.carriage_price'() {
            this.setTotals();
        },
    },

    methods: {
        setTotals() {
            const {cost_price, selling_price, vat,} = orderProductsTotals(this.form.order_products);
            this.form.cost_price = cost_price;
            this.form.selling_price = selling_price + Number(this.form.carriage_price);
            this.form.vat = vat;
        },
        submit() {
            this.$inertia.put(this.route('orders.update', this.order.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
        destroy() {
            if (confirm('Wil je deze order verwijderen?')) {
                this.$inertia.delete(this.route('orders.destroy', this.order.id));
            }
        },
        restore() {
            if (confirm('Wil je deze order herstellen?')) {
                this.$inertia.put(this.route('orders.restore', this.order.id));
            }
        },
    },
};
</script>
