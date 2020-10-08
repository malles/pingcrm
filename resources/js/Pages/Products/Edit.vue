<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('products')">
                Produkten
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="product.deleted_at" class="mb-6" @restore="restore">
            Dit produkt is verwijderd.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full"
                                label="Naam" />
                    <select-input v-model="form.supplier_id" :error="errors.supplier_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Leverancier">
                        <option :value="null">Maak een keuze</option>
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                            {{ supplier.name }}
                        </option>
                    </select-input>
                    <text-input v-model="form.parc_reference" :error="errors.parc_reference" class="pr-6 pb-8 w-full"
                                label="Referentie park" />
                    <text-input v-model="form.supplier_reference" :error="errors.supplier_reference" class="pr-6 pb-8 w-full"
                                label="Referentie leverancier" />
                    <text-input v-model="form.cost_price" :error="errors.cost_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Inkoopprijs" />
                    <text-input v-model="form.selling_price" :error="errors.selling_price"
                                type="number" step="0.01" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Verkoopprijs" />
                    <textarea-input v-model="form.notes" :error="errors.notes" class="pr-6 pb-8 w-full"
                                    label="Notities" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1"
                            type="button"
                            @click="destroy">
                        Verwijder produkt
                    </button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">
                        Produkt opslaan
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
        product: Object,
        suppliers: Array,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.product.name,
                supplier_id: this.product.supplier_id,
                parc_reference: this.product.parc_reference,
                supplier_reference: this.product.supplier_reference,
                cost_price: this.product.cost_price,
                selling_price: this.product.selling_price,
                notes: this.product.notes,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.put(this.route('products.update', this.product.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
        destroy() {
            if (confirm('Wil je dit produkt verwijderen?')) {
                this.$inertia.delete(this.route('products.destroy', this.product.id));
            }
        },
        restore() {
            if (confirm('Wil je dit produkt herstellen?')) {
                this.$inertia.put(this.route('products.restore', this.product.id));
            }
        },
    },
};
</script>
