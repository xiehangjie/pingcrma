<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <Head title="鳄鱼信息列表" />
    <div class="max-w-7xl mx-auto">
      <!-- 标题和操作栏 -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
            鳄鱼信息列表
            <span class="text-emerald-600 ml-2">🐊</span>
          </h1>
          <p class="mt-2 text-gray-500">当前共 {{ crocodiles.length }} 条鳄鱼信息</p>
        </div>
        <Link 
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 
                 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                 hover:from-emerald-600 hover:to-emerald-700 focus:ring-2 focus:ring-emerald-500 
                 focus:ring-offset-2 focus:outline-none"
          href="/crocodile-management/basic-info/create"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          添加鳄鱼信息
        </Link>
      </div>

      <!-- 数据加载状态 -->
      <div v-if="$page.loading" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <p class="mt-4 text-sm text-gray-500">正在加载鳄鱼信息...</p>
      </div>

      <!-- 数据加载错误 -->
      <div v-if="$page.error" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="mt-4 text-sm text-red-500">加载鳄鱼信息时出现错误，请稍后再试。</p>
      </div>

      <!-- 数据表格 -->
      <div v-if="!$page.loading && !$page.error" class="bg-white rounded-xl shadow-lg overflow-x-auto ring-1 ring-black ring-opacity-5">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <!-- 唯一身份标识 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                唯一身份标识
              </th>
              <!-- RFID电子标签 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                RFID电子标签
              </th>
              <!-- 物种类型 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                物种类型
              </th>
              <!-- 性别 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                性别
              </th>
              <!-- 出生日期 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                出生日期
              </th>
              <!-- 年龄 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                年龄
              </th>
              <!-- 体重 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                体重 (kg)
              </th>
              <!-- 养殖池编号 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                养殖池编号
              </th>
              <!-- 健康状况 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                健康状况
              </th>
              <!-- 遗传谱系 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                遗传谱系
              </th>
              <!-- 操作 -->
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                操作
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr 
              v-for="crocodile in crocodiles" 
              :key="crocodile.id"
              class="hover:bg-gray-50 transition-colors cursor-pointer"
            >
              <!-- 唯一身份标识 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.unique_id }}
              </td>
              <!-- RFID电子标签 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.rfid_tag }}
              </td>
              <!-- 物种类型 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.species_type }}
              </td>
              <!-- 性别 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.gender }}
              </td>
              <!-- 出生日期 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ formatDate(crocodile.birth_date) }}
              </td>
              <!-- 年龄 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ crocodile.age }} 岁
              </td>
              <!-- 体重 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                {{ crocodile.weight }}
              </td>
              <!-- 养殖池编号 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600 font-medium">
                #{{ crocodile.pool_id }}
              </td>
              <!-- 健康状况 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.health_status }}
              </td>
              <!-- 遗传谱系 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ crocodile.genetic_lineage }}
              </td>
              <!-- 操作 -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <Link 
                  class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:outline-none mr-2"
                  :href="`/crocodile-management/basic-info/${crocodile.id}/edit`"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  编辑
                </Link>
                <button 
                  class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                  @click="deleteCrocodile(crocodile.id)"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                  删除
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- 空状态 -->
        <div v-if="!crocodiles.length" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
          <p class="mt-4 text-sm text-gray-500">暂时没有鳄鱼信息，点击上方按钮添加</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'

export default {
  components: {
    Head,
    Link
  },
  props: {
    crocodiles: Array
  },
  methods: {
    formatDate(date) {
      return dayjs(date).format('YYYY-MM-DD')
    },
    deleteCrocodile(id) {
      if (confirm('你确定要删除这条鳄鱼信息吗？')) {
        this.$inertia.delete(`/crocodile-management/basic-info/${id}`)
      }
    }
  }
}
</script>