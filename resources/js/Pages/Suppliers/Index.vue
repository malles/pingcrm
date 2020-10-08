<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Leveranciers</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Verwijderd:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null">Actief</option>
                    <option value="with">Met verwijderd</option>
                    <option value="only">Alleen verwijderd</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('suppliers.create')">
                <span>Nieuwe</span>
                <span class="hidden md:inline">leverancier</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Naam</th>
                    <th class="px-6 pt-6 pb-4">Plaats</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Contact</th>
                </tr>
                <tr v-for="supplier in suppliers.data" :key="supplier.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500"
                                      :href="route('suppliers.edit', supplier.id)">
                            {{ supplier.name }}
                            <icon v-if="supplier.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('suppliers.edit', supplier.id)"
                                      tabindex="-1">
                            {{ supplier.city }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('suppliers.edit', supplier.id)"
                                      tabindex="-1">
                            {{ supplier.contact }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('suppliers.edit', supplier.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="suppliers.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="5">Geen leveranciers gevonden.</td>
                </tr>
            </table>
        </div>
        <pagination :links="suppliers.links" />
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
    metaInfo: {title: 'Leveranciers',},
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    props: {
        suppliers: Object,
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
                this.$inertia.replace(this.route('suppliers', Object.keys(query).length ? query : {remember: 'forget',}));
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
