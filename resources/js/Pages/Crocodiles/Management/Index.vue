<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-8">
    <Head title="鳄鱼信息管理" />
    <div class="max-w-7xl mx-auto">
      <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center">
          鳄鱼信息管理
          <span class="text-emerald-500 ml-3">🐊</span>
        </h1>
        <p class="text-lg text-gray-600">全面管理鳄鱼养殖的各项数据信息</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Link 
          class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-300 transition-all hover:-translate-y-1 hover:shadow-md group"
          href="/crocodile-management/basic-info"
        >
          <div class="flex items-center mb-4">
            <div class="bg-emerald-50 p-3 rounded-lg mr-4">
              <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600">基本信息</h2>
          </div>
          <p class="text-gray-500">管理鳄鱼身份标识、物种类型、年龄等基础数据</p>
        </Link>

        <Link 
          class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-300 transition-all hover:-translate-y-1 hover:shadow-md group"
          href="/crocodile-management/feeding-record"
        >
          <div class="flex items-center mb-4">
            <div class="bg-emerald-50 p-3 rounded-lg mr-4">
              <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600">饲养记录</h2>
          </div>
          <p class="text-gray-500">记录饲料投喂、进食情况及饲养员信息</p>
        </Link>

        <Link 
          class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-300 transition-all hover:-translate-y-1 hover:shadow-md group"
          href="/crocodile-management/health-status"
        >
          <div class="flex items-center mb-4">
            <div class="bg-emerald-50 p-3 rounded-lg mr-4">
              <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600">健康情况</h2>
          </div>
          <p class="text-gray-500">跟踪疫苗接种、疾病治疗及体检记录</p>
        </Link>

        <Link 
          class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-300 transition-all hover:-translate-y-1 hover:shadow-md group"
          href="/crocodile-management/reproduction-info"
        >
          <div class="flex items-center mb-4">
            <div class="bg-emerald-50 p-3 rounded-lg mr-4">
              <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600">繁殖信息</h2>
          </div>
          <p class="text-gray-500">管理交配记录、产蛋情况及幼鳄成长数据</p>
        </Link>

        <Link 
          class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-300 transition-all hover:-translate-y-1 hover:shadow-md group"
          href="/crocodile-management/enclosure"
        >
          <div class="flex items-center mb-4">
            <div class="bg-emerald-50 p-3 rounded-lg mr-4">
              <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600">圈舍分配</h2>
          </div>
          <p class="text-gray-500">查看和管理鳄鱼圈舍分配及环境参数</p>
        </Link>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'


export default {
  components: {
    Head,
    Link
  },
  layout: Layout,
}
</script>

<style scoped>
/* 添加平滑过渡效果 */
.transition-all {
  transition: all 0.3s ease;
}

/* 优化悬停阴影效果 */
.hover\:shadow-md {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* 卡片悬停动画 */
.group:hover {
  transform: translateY(-2px);
}
</style>