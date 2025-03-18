<template>
  <div>
    <Head title="Login Logs" />
    <h1 class="mb-8 text-3xl font-bold">Login Logs</h1>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">User</th>
          <th class="pb-4 pt-6 px-6">IP Address</th>
          <th class="pb-4 pt-6 px-6">Login Time</th>
        </tr>
        <tr v-for="log in loginLogs.data" :key="log.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t px-6 py-4">
            {{ log.user.name }}
          </td>
          <td class="border-t px-6 py-4">
            {{ log.ip_address }}
          </td>
          <td class="border-t px-6 py-4">
            {{ log.login_time }}
          </td>
        </tr>
        <tr v-if="loginLogs.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="3">No login logs found.</td>
        </tr>
      </table>
      <div class="mt-4">
        <pagination :paginator="loginLogs" />
      </div>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Pagination from '@/Shared/Pagination.vue'

export default {
  components: {
    Head,
    Pagination
  },
  layout: Layout,
  props: {
    loginLogs: Object
  }
}
</script>