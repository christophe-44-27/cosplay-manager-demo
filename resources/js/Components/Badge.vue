<template>
  <span
      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
      :class="{
      'bg-gray-100 text-gray-800': variant === 'default',
      'bg-green-100 text-green-800': variant === 'success',
      'bg-yellow-100 text-yellow-800': variant === 'warning',
      'bg-blue-100 text-blue-800': variant === 'info',
      'bg-red-100 text-red-800': variant === 'danger'
    }"
  >
    <slot />
  </span>
</template>

<script setup>
defineProps({
    variant: {
        type: String,
        default: 'default',
        validator: (value) => ['default', 'success', 'warning', 'info', 'danger'].includes(value)
    }
})
</script>
