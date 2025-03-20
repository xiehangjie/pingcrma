<template>
  <div>
    <Head title="添加鳄鱼信息" />
    <h1 class="mb-8 text-3xl font-bold">添加鳄鱼信息</h1>
    <!-- 错误提示 -->
    <div v-if="form.errors.any()" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">错误！</strong>
      <span class="block sm:inline">{{ form.errors.all().join(', ') }}</span>
    </div>
    <!-- 成功提示 -->
    <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">成功！</strong>
      <span class="block sm:inline">{{ successMessage }}</span>
    </div>
    <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="store">
      <div class="px-10 py-12">
        <text-input v-model="form.name" :error="form.errors.name" class="mt-10" label="名称" type="text" autofocus autocapitalize="off" />
        <text-input v-model="form.age" :error="form.errors.age" class="mt-6" label="年龄" type="number" />
        <text-input v-model="form.weight" :error="form.errors.weight" class="mt-6" label="体重" type="number" step="0.01" />
        <text-input v-model="form.pool_id" :error="form.errors.pool_id" class="mt-6" label="养殖池编号" type="number" />
        <!-- 新增性别字段 -->
        <text-input v-model="form.gender" :error="form.errors.gender" class="mt-6" label="性别" type="text" />
        <!-- 新增出生日期字段 -->
        <text-input v-model="form.birth_date" :error="form.errors.birth_date" class="mt-6" label="出生日期" type="date" />
        <!-- 新增健康状况字段 -->
        <text-input v-model="form.health_status" :error="form.errors.health_status" class="mt-6" label="健康状况" type="text" />
      </div>
      <div class="flex px-10 py-4 bg-emerald-50 border-t border-emerald-100">
        <button 
          class="bg-gray-300 text-gray-700 px-6 py-3 rounded-md font-bold hover:bg-gray-400 focus:ring-gray-300 focus:ring-offset-2 focus:ring-opacity-50 mr-4" 
          type="button"
          @click="cancel"
        >
          取消
        </button>
        <loading-button 
          :loading="form.processing" 
          class="bg-emerald-500 text-white px-6 py-3 rounded-md font-bold hover:bg-emerald-600 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-opacity-50 ml-auto" 
          type="submit"
        >
          保存
        </loading-button>
      </div>
    </form>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    TextInput,
    LoadingButton
  },
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        age: null,
        weight: null,
        pool_id: null,
        // 新增字段初始化
        gender: '',
        birth_date: '',
        health_status: ''
      }),
      successMessage: ''
    }
  },
  methods: {
    store() {
      // 前端基本验证
      if (!this.form.name || !this.form.age || !this.form.weight || !this.form.pool_id ||!this.form.gender ||!this.form.birth_date ||!this.form.health_status) {
        this.form.setError('general', '所有字段均为必填项');
        return;
      }
      if (this.form.age < 0 || this.form.weight < 0) {
        this.form.setError('general', '年龄和体重必须为正数');
        return;
      }
      this.form.post('/crocodile-management/basic-info', {
        onSuccess: () => {
          this.successMessage = '鳄鱼信息添加成功！';
          // 清空表单
          this.form.reset();
        },
        onError: () => {
          // 错误处理已经在模板中通过 form.errors 显示
        }
      });
    },
    cancel() {
      history.back();
    }
  }
}
</script>