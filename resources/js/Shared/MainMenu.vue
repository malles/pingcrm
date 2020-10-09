<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon :icon="['fad', 'tachometer-alt']" class="w-4 h-4 mr-2" :class="isUrl('') ? 'text-white' : 'text-indigo-400 group-hover:text-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('parcs')">
        <icon :icon="['fad', 'house-day']" class="w-4 h-4 mr-2" :class="isUrl('parken') ? 'text-white' : 'text-indigo-400 group-hover:text-white'" />
        <div :class="isUrl('parken') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Parken</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('suppliers')">
        <icon :icon="['fad', 'truck-loading']" class="w-4 h-4 mr-2" :class="isUrl('leveranciers') ? 'text-white' : 'text-indigo-400 group-hover:text-white'" />
        <div :class="isUrl('leveranciers') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Leveranciers</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('products')">
        <icon :icon="['fad', 'boxes-alt']" class="w-4 h-4 mr-2" :class="isUrl('produkten') ? 'text-white' : 'text-indigo-400 group-hover:text-white'" />
        <div :class="isUrl('produkten') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Produkten</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('orders')">
        <icon :icon="['fad', 'file-signature']" class="w-4 h-4 mr-2" :class="isUrl('orders') ? 'text-white' : 'text-indigo-400 group-hover:text-white'" />
        <div :class="isUrl('orders') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Orders</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>

export default {
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
