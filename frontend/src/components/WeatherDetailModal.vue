<script setup lang="ts">
import { VueFinalModal } from "vue-final-modal";

defineProps<{
  data?: object;
}>();
</script>

<template>
  <VueFinalModal
      class="confirm-modal flex flex-col items-center justify-center w-screen min-h-screen"
      content-class="confirm-modal-content w-full max-w-screen-sm"
      overlay-transition="vfm-fade"
      content-transition="vfm-fade"
  >
    <div class="bg-white p-10 rounded-xl ring-8 ring-white ring-opacity-40">
      <div class="flex justify-between">
        <div class="flex flex-col">
          <span class="text-6xl font-bold">{{ data?.weather.summary.current_temp }}</span>
          <span class="font-semibold mt-1 text-gray-500">{{ data?.weather.summary.location }}</span>
        </div>
        <div class="flex flex-col text-right">
          <span class="text-xl font-bold text-purple-500">{{ data?.weather.details.status }}</span>
          <span class="font-normal mt-1 text-gray-500">{{ data?.weather.details.description }}</span>
        </div>
      </div>
      <div class="flex justify-between mt-12">
        <div class="flex flex-col items-center">
          <span class="font-semibold text-sm text-gray-400">Min. temp.</span>
          <span class="font-semibold mt-1 text-lg">{{ data?.weather.details.min_temp }}</span>
        </div>
        <div class="flex flex-col items-center">
          <span class="font-semibold text-sm text-gray-400">Max. temp.</span>
          <span class="font-semibold mt-1 text-lg">{{ data?.weather.details.max_temp }}</span>
        </div>
        <div class="flex flex-col items-center">
          <span class="font-semibold text-sm text-gray-400">Feels like</span>
          <span class="font-semibold mt-1 text-lg">{{ data?.weather.details.feels_like }}</span>
        </div>
        <div class="flex flex-col items-center">
          <span class="font-semibold text-sm text-gray-400">Pressure</span>
          <span class="font-semibold mt-1 text-lg">{{ data?.weather.details.pressure }}</span>
        </div>
        <div class="flex flex-col items-center">
          <span class="font-semibold text-sm text-gray-400">Humidity</span>
          <span class="font-semibold mt-1 text-lg">{{ data?.weather.details.humidity }}</span>
        </div>
      </div>
    </div>
  </VueFinalModal>
</template>
