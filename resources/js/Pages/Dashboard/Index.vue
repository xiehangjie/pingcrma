<template>
  <div class="p-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <Head title="Dashboard" />
    <div class="max-w-7xl mx-auto">
      <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">小型鳄鱼养殖场管理系统</h1>
        <p class="text-lg text-gray-600 max-w-3xl leading-relaxed">
          欢迎使用养殖场管理平台，以下模块可帮助您高效管理养殖场各项业务
          <span class="text-emerald-500 ml-1">🐊</span>
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- 用户信息业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">用户信息管理</h2>
            </div>
            <p class="text-gray-500 mb-6">管理系统用户信息、权限设置与访问控制</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/users">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>

        <!-- 鳄鱼信息管理业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">鳄鱼信息管理</h2>
            </div>
            <p class="text-gray-500 mb-6">管理鳄鱼基本信息、健康状况与繁殖记录</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/crocodile-management">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>

        <!-- 环境监控业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">环境监控</h2>
            </div>
            <p class="text-gray-500 mb-6">实时监测养殖场温度、湿度及水质参数</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/environment-monitoring">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>

        <!-- 采购业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">采购管理</h2>
            </div>
            <p class="text-gray-500 mb-6">管理饲料、药品等物资采购与供应商信息</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/purchase-management">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>

        <!-- 销售业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">销售管理</h2>
            </div>
            <p class="text-gray-500 mb-6">处理鳄鱼及副产品销售订单与客户关系</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/sales-management">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>

        <!-- 库存管理业务 -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:border-emerald-100 transition-all duration-300 hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="bg-emerald-50 p-3 rounded-lg mr-4">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-800">库存管理</h2>
            </div>
            <p class="text-gray-500 mb-6">跟踪饲料、药品等物资的库存与使用情况</p>
            <Link class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-medium rounded-lg hover:from-emerald-500 hover:to-emerald-600 transition-all focus:ring-2 focus:ring-emerald-300 focus:outline-none" href="/inventory-management">
              进入管理
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </Link>
          </div>
        </div>
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
/* 添加卡片悬停动画 */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 200ms;
}

/* 优化渐变背景的渲染性能 */
.bg-gradient-to-r {
  background-size: 200% auto;
  background-position: 0% center;
  transition: background-position 0.5s ease;
}

.bg-gradient-to-r:hover {
  background-position: 100% center;
}
</style>