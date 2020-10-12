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
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.reference" :error="errors.reference" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Ordernummer" />
                    <text-input v-model="form.order_date" :error="errors.order_date"
                                type="datetime-local" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Datum" />
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
                    <text-input v-model="form.cost_price" :error="errors.cost_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="Inkoopprijs" />
                    <text-input v-model="form.selling_price" :error="errors.selling_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="Verkoopprijs" />
                    <text-input v-model="form.vat" :error="errors.vat"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/3"
                                label="BTW" />
                    <text-input v-model="form.ordered_at" :error="errors.ordered_at"
                                type="date" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Datum" />
                    <text-input v-model="form.shipped_at" :error="errors.shipped_at"
                                type="date" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Datum" />
                    <text-input v-model="form.received_at" :error="errors.received_at"
                                type="date" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Datum" />
                    <text-input v-model="form.invoiced_at" :error="errors.invoiced_at"
                                type="date" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Datum" />
                    <text-input v-model="form.internal_invoice_id" :error="errors.internal_invoice_id"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Intern factuurnummer" />
                    <text-input v-model="form.external_invoice_id" :error="errors.external_invoice_id"
                                class="pr-6 pb-8 w-full lg:w-1/2"
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
</template>

<script>
import moment from 'moment';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import SelectInput from '@/Shared/SelectInput';
import TextInput from '@/Shared/TextInput';
import TrashedMessage from '@/Shared/TrashedMessage';
import TextareaInput from '@/Shared/TextareaInput';

export default {
    metaInfo() {
        return {
            title: this.form.name,
        };
    },
    layout: Layout,
    components: {
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
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                order_date: moment(this.order.order_date).format('YYYY-MM-DDTHH:mm:ss'),
                reference: this.order.reference,
                park_id: this.order.park_id,
                supplier_id: this.order.supplier_id,
                internal_invoice_id: this.order.internal_invoice_id,
                external_invoice_id: this.order.external_invoice_id,
                cost_price: this.order.cost_price,
                selling_price: this.order.selling_price,
                vat: this.order.vat,
                ordered_at: this.order.ordered_at,
                shipped_at: this.order.shipped_at,
                received_at: this.order.received_at,
                invoiced_at: this.order.invoiced_at,
                notes: this.order.notes,
            },
        };
    },
    methods: {
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
