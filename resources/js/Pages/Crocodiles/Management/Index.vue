<template>
  <div>
    <Head title="鳄鱼信息管理" />
    <h1 class="mb-8 text-3xl font-bold">鳄鱼信息管理</h1>
    <div class="flex space-x-4">
      <Link class="btn-indigo" href="/crocodile-management/basic-info">基本信息</Link>
      <Link class="btn-indigo" href="/crocodile-management/feeding-record">饲养记录</Link>
      <Link class="btn-indigo" href="/crocodile-management/health-status">健康情况</Link>
      <Link class="btn-indigo" href="/crocodile-management/reproduction-info">繁殖信息</Link>
      <Link class="btn-indigo" href="/crocodile-management/enclosure">圈舍分配</Link>
      <Link class="btn-indigo" href="/crocodile-management/inventory-management">库存管理</Link>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'

export default {
  components: {
    Head,
    Link
  }
}
</script>