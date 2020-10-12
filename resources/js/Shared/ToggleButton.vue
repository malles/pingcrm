<template>
  <button :class="{'active': value}" type="button" class="flex items-center" @click="$emit('input', !value)">
      <slot />
    <Icon :icon="['far', value ? 'chevron-up' : 'chevron-down']" class="fa-1x ml-2" />
  </button>
</template>

<script>
export default {
    props: {
        value: Boolean,
    },
};
</script>
