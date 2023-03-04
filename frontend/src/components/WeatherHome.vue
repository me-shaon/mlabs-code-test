<script>
export default {
  data: () => ({
    users: null
  }),

  created() {
    this.fetchData()
  },

  methods: {
    async fetchData() {
      const url = 'http://localhost/'
      this.users = await (await fetch(url)).json()
    }
  }
}
</script>

<template>

  <div class="flex flex-col items-center justify-center w-screen min-h-screen text-gray-700 p-10 bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-200 ">
    <div class="flex flex-col space-y-6 w-full max-w-screen-lg bg-white p-10 mt-10 rounded-xl ring-8 ring-white ring-opacity-40">

      <div v-if="!users">
        Pinging the api...
      </div>

      <div v-else class="divide-y divide-dashed">
        <div v-for="user in users" class="flex justify-between items-center py-4">
          <span class="font-semibold text-lg w-2/4">{{ user.name }}</span>
          <span class="font-normal text-lg w-2/4">{{ user.weather.summary.location }}</span>
          <span class="font-normal text-lg w-1/4 text-right">{{ user.weather.summary.min_temp }} / {{ user.weather.summary.max_temp }}</span>
        </div>
      </div>
    </div>
  </div>
</template>