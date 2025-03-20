<template>
  <div>
    <!-- 设置页面标题为登录日志 -->
    <Head title="登录日志" />
    <!-- 页面主标题 -->
    <h1 class="mb-8 text-3xl font-bold">登录日志</h1>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <!-- 日志表格 -->
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <!-- 表格表头 -->
          <th class="pb-4 pt-6 px-6">用户</th>
          <th class="pb-4 pt-6 px-6">IP 地址</th>
          <th class="pb-4 pt-6 px-6">登录时间</th>
        </tr>
        <!-- 循环展示登录日志数据 -->
        <tr v-for="log in loginLogs.data" :key="log.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t px-6 py-4">
            {{ log.user ? `${log.user.first_name} ${log.user.last_name}` : '未找到用户信息' }}
          </td>
          <td class="border-t px-6 py-4">
            {{ log.ip_address }}
          </td>
          <td class="border-t px-6 py-4">
            {{ log.login_time }}
          </td>
        </tr>
        <!-- 如果没有登录日志数据，显示提示信息 -->
        <tr v-if="loginLogs.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="3">未找到登录日志。</td>
        </tr>
      </table>
      <!-- 分页组件 -->
      <div class="mt-4">
        <Pagination :links="loginLogs.links">
          <template #prev-button>
            <button 
              :disabled="!loginLogs.prev_page_url" 
              @click="loginLogs.prev_page_url && $inertia.visit(loginLogs.prev_page_url)"
              class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm"
            >
              上一页
            </button>
          </template>
          <template #next-button>
            <button 
              :disabled="!loginLogs.next_page_url" 
              @click="loginLogs.next_page_url && $inertia.visit(loginLogs.next_page_url)"
              class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm"
            >
              下一页
            </button>
          </template>
        </Pagination>
      </div>
    </div>
  </div>
</template>

<script>
// 引入 Inertia.js 的 Head 组件
import { Head } from '@inertiajs/vue3'
// 引入共享布局组件
import Layout from '@/Shared/Layout.vue'
// 引入分页组件
import Pagination from '@/Shared/Pagination.vue'

export default {
  components: {
    Head,
    Pagination
  },
  layout: Layout,
  props: {
    // 接收登录日志数据作为组件属性
    loginLogs: Object
  }
}
</script>