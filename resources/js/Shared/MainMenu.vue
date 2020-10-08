<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('parcs')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('parken') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('parken') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Parken</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('suppliers')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('leveranciers') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('leveranciers') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Leveranciers</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('products')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('produkten') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('produkten') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Produkten</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon';

export default {
    components: {
        Icon,
    },
    props: {
        url: String,
    },
    methods: {
        isUrl(...urls) {
            if (urls[0] === '') {
                return this.url === '';
            }

            return urls.filter(url => this.url.startsWith(url)).length;
        },
    },
};
</script>
