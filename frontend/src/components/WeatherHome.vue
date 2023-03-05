<script setup lang="ts">
import { onMounted, ref } from "vue";
import { ModalsContainer, useModal } from "vue-final-modal";
import WeatherDetailModal from "@/components/WeatherDetailModal.vue";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

const selectedUser = ref(null);
const users = ref([]);
const loading = ref(false);
const echo = new Echo({
  broadcaster: 'pusher',
  key: '1efa6f49b7dabae488be',
  cluster: 'ap2',
  forceTLS: true,
});

echo.channel("users-list")
    .listen("UserDataUpdated", (e) => {
      users.value = e.users;
    });

const { open } = useModal({
  component: WeatherDetailModal,
  attrs: {
    data: selectedUser,
  },
});

const showModal = (user: any) => {
  if (!user || !user.weather) {
    return;
  }
  selectedUser.value = user;
  open();
};

onMounted(async () => {
  loading.value = true;
  const response = await fetch("http://localhost/api/users");

  if (response.ok) {
    users.value = await response.json();
  }
  loading.value = false;
});
</script>

<template>
  <div>
    <div class="flex flex-col items-center justify-center w-screen min-h-screen text-gray-700 p-10 bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-200 ">
      <h2 class="text-center text-3xl">Weather app</h2>
      <div class="flex flex-col space-y-6 w-full max-w-screen-lg bg-white p-10 mt-10 rounded-xl ring-8 ring-white ring-opacity-40">
        <div v-if="loading" class="flex justify-center">
          <img src="/loader.gif" alt="Loading..."/>
        </div>

        <div v-else>
          <div v-if="!users">
            <h3 class="text-center text-gray-500">No users data found.</h3>
          </div>
          <div v-else class="divide-y divide-dashed">
            <div v-for="user in users" :key="user.uuid" @click="showModal(user)" class="flex justify-between items-center py-4 cursor-pointer">
              <span class="font-semibold text-lg w-2/4">{{ user.name }}</span>
              <span class="font-normal text-lg w-2/4 text-center">{{ user?.weather?.summary.location || '-' }}</span>
              <span class="font-normal text-lg w-1/4 text-right">{{ user?.weather?.summary.current_temp || '-' }}</span>
            </div>

            <ModalsContainer />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
