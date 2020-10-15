<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Orders</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Verwijderd:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null">Actief</option>
                    <option value="with">Met verwijderd</option>
                    <option value="only">Alleen verwijderd</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('orders.create')">
                <span>Nieuwe</span>
                <span class="hidden md:inline">order</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Datum</th>
                    <th class="px-6 pt-6 pb-4">Nummer</th>
                    <th class="px-6 pt-6 pb-4">Park Nummer</th>
                    <th class="px-6 pt-6 pb-4">Park</th>
                    <th class="px-6 pt-6 pb-4">Leverancier</th>
                    <th class="px-6 pt-6 pb-4">Kostprijs</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Verkoopprijs</th>
                </tr>
                <tr v-for="order in orders.data" :key="order.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('orders.edit', order.id)">
                            {{ order.ordered_at | date }}
                            <icon v-if="order.deleted_at" :icon="['far', 'trash-alt']"
                                  class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('orders.edit', order.id)">
                            {{ order.reference }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('orders.edit', order.id)">
                            {{ order.park_reference }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('orders.edit', order.id)"
                                      tabindex="-1">
                            <div v-if="order.park">
                                {{ order.park.code }}
                            </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('orders.edit', order.id)"
                                      tabindex="-1">
                            <div v-if="order.supplier">
                                {{ order.supplier.name }}
                            </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('orders.edit', order.id)"
                                      tabindex="-1">
                            {{ order.cost_price | currency }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('orders.edit', order.id)"
                                      tabindex="-1">
                            {{ order.selling_price | currency }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('orders.edit', order.id)"
                                      tabindex="-1">
                            <icon :icon="['far', 'chevron-right']" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="orders.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="7">Geen orders gevonden.</td>
                </tr>
            </table>
        </div>
        <pagination :links="orders.links" />
    </div>
</template>

<script>
import Layout from '@/Shared/Layout';
import mapValues from 'lodash/mapValues';
import Pagination from '@/Shared/Pagination';
import pickBy from 'lodash/pickBy';
import SearchFilter from '@/Shared/SearchFilter';
import throttle from 'lodash/throttle';

export default {
    metaInfo: {title: 'Orders',},
    layout: Layout,
    components: {
        Pagination,
        SearchFilter,
    },
    props: {
        orders: Object,
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
                this.$inertia.replace(this.route('orders', Object.keys(query).length ? query : {remember: 'forget',}));
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
