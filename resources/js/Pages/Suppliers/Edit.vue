<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('suppliers')">
                Leveranciers
            </inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="supplier.deleted_at" class="mb-6" @restore="restore">
            Dit park is verwijderd.
        </trashed-message>
        <div class="-mr-6 -mb-8 flex flex-wrap">
            <div class="pr-6 pb-8 xl:flex-1">
                <div class="bg-white rounded shadow overflow-hidden">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full"
                                        label="Naam" />
                            <text-input v-model="form.address" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="Adres" />
                            <text-input v-model="form.postal_code" :error="errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="Postcode" />
                            <text-input v-model="form.city" :error="errors.city" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="Plaats" />
                            <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2"
                                          label="Land">
                                <option :value="null">Maak een keuze</option>
                                <option value="BE">België</option>
                                <option value="DE">Duitsland</option>
                                <option value="NL">Nederland</option>
                                <option value="UK">Verenigd Koninkrijk</option>
                            </select-input>
                            <text-input v-model="form.contact" :error="errors.contact" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="Contactpersoon" />
                            <text-input v-model="form.email" :error="errors.email" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="E-mail" />
                            <text-input v-model="form.phone" :error="errors.phone" class="pr-6 pb-8 w-full lg:w-1/2"
                                        label="Telefoon" />
                            <textarea-input v-model="form.notes" :error="errors.notes" class="pr-6 pb-8 w-full"
                                            label="Notities" />
                        </div>
                        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                            <button v-if="!supplier.deleted_at" class="text-red-600 hover:underline" tabindex="-1"
                                    type="button" @click="destroy">
                                Verwijder leverancier
                            </button>
                            <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">
                                Sla leverancier op
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pr-6 pb-8 flex-1 xl:flex-none">
                <div class="bg-gray-100 w-full rounded shadow p-8">
                    <h2 class="font-bold text-2xl">Produkten</h2>
                    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-6 pb-4">Naam</th>
                                <th class="px-6 pt-6 pb-4">Kostprijs</th>
                                <th class="px-6 pt-6 pb-4" colspan="2">Verkoopprijs</th>
                            </tr>
                            <tr v-for="product in supplier.products" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t">
                                    <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                  :href="route('products.edit', product.id)">
                                        {{ product.name }}
                                        <icon v-if="product.deleted_at" :icon="['far', 'trash-alt']"
                                              class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                                    </inertia-link>
                                </td>
                                <td class="border-t">
                                    <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)"
                                                  tabindex="-1">
                                        {{ product.cost_price | currency }}
                                    </inertia-link>
                                </td>
                                <td class="border-t">
                                    <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)"
                                                  tabindex="-1">
                                        {{ product.selling_price | currency }}
                                    </inertia-link>
                                </td>
                                <td class="border-t w-px">
                                    <inertia-link class="px-4 flex items-center" :href="route('products.edit', product.id)"
                                                  tabindex="-1">
                                        <icon :icon="['far', 'chevron-right']" class="block w-6 h-6 fill-gray-400" />
                                    </inertia-link>
                                </td>
                            </tr>
                            <tr v-if="supplier.products.length === 0">
                                <td class="border-t px-6 py-4" colspan="4">Geen produkten gevonden.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import SelectInput from '@/Shared/SelectInput';
import TextareaInput from '@/Shared/TextareaInput';
import TextInput from '@/Shared/TextInput';
import TrashedMessage from '@/Shared/TrashedMessage';

export default {
    metaInfo() {
        return {title: this.form.name,};
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
        supplier: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.supplier.name,
                address: this.supplier.address,
                city: this.supplier.city,
                postal_code: this.supplier.postal_code,
                country: this.supplier.country,
                contact: this.supplier.contact,
                email: this.supplier.email,
                phone: this.supplier.phone,
                notes: this.supplier.notes,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.put(this.route('suppliers.update', this.supplier.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            });
        },
        destroy() {
            if (confirm('Wil je deze leverancier verwijderen?')) {
                this.$inertia.delete(this.route('suppliers.destroy', this.supplier.id));
            }
        },
        restore() {
            if (confirm('Wil je deze leverancier herstellen?')) {
                this.$inertia.put(this.route('suppliers.restore', this.supplier.id));
            }
        },
    },
};
</script>
