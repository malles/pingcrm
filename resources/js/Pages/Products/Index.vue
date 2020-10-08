<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Produkten</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Verwijderd:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null">Actief</option>
                    <option value="with">Met verwijderd</option>
                    <option value="only">Alleen verwijderd</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('products.create')">
                <span>Nieuw</span>
                <span class="hidden md:inline">produkt</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">Leverancier</th>
                    <th class="px-6 pt-6 pb-4">Kostprijs</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Verkoopprijs</th>
                </tr>
                <tr v-for="product in products.data" :key="product.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('products.edit', product.id)">
                            {{ product.name }}
                            <icon v-if="product.deleted_at" name="trash"
                                  class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)"
                                      tabindex="-1">
                            <div v-if="product.supplier">
                                {{ product.supplier.name }}
                            </div>
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
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="products.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Geen produkten gevonden.</td>
                </tr>
            </table>
        </div>
        <pagination :links="products.links" />
    </div>
</template>

<script>
import Icon from '@/Shared/Icon';
import Layout from '@/Shared/Layout';
import mapValues from 'lodash/mapValues';
import Pagination from '@/Shared/Pagination';
import pickBy from 'lodash/pickBy';
import SearchFilter from '@/Shared/SearchFilter';
import throttle from 'lodash/throttle';

export default {
    metaInfo: {title: 'Products',},
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    props: {
        products: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(this.route('products', Object.keys(query).length ? query : {remember: 'forget',}));
            }, 150),
            deep: true,
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        },
    },
};
</script>
