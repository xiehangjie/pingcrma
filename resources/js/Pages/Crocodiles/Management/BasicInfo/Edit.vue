<template>
  <div>
    <Head :title="`编辑 ${form.unique_id} 鳄鱼信息`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/crocodile-management/basic-info">鳄鱼信息列表</Link>
      <span class="text-indigo-400 font-medium">/</span>
      编辑 {{ form.unique_id }} 鳄鱼信息
    </h1>
    <!-- 错误提示 -->
    <div v-if="Object.keys(form.errors).length > 0" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">错误！</strong>
      <span class="block sm:inline">{{ Object.values(form.errors).join(', ') }}</span>
    </div>
    <!-- 成功提示 -->
    <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">成功！</strong>
      <span class="block sm:inline">{{ successMessage }}</span>
    </div>
    <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="update">
      <div class="px-10 py-12">
        <!-- 唯一身份标识 -->
        <text-input v-model="form.unique_id" :error="form.errors.unique_id" class="mt-10" label="唯一身份标识" type="text" autofocus autocapitalize="off" />
        <!-- RFID 电子标签 -->
        <text-input v-model="form.rfid_tag" :error="form.errors.rfid_tag" class="mt-6" label="RFID 电子标签" type="text" />
        <!-- 物种类型 -->
        <text-input v-model="form.species_type" :error="form.errors.species_type" class="mt-6" label="物种类型" type="text" />
        <!-- 性别 -->
        <text-input v-model="form.gender" :error="form.errors.gender" class="mt-6" label="性别" type="text" />
        <!-- 出生日期 -->
        <text-input v-model="form.birth_date" :error="form.errors.birth_date" class="mt-6" label="出生日期" type="date" />
        <!-- 遗传谱系 -->
        <text-input v-model="form.genetic_lineage" :error="form.errors.genetic_lineage" class="mt-6" label="遗传谱系" type="text" />
        <!-- 年龄 -->
        <text-input v-model="form.age" :error="form.errors.age" class="mt-6" label="年龄" type="number" />
        <!-- 体重 -->
        <text-input v-model="form.weight" :error="form.errors.weight" class="mt-6" label="体重" type="number" step="0.01" />
        <!-- 养殖池编号 -->
        <text-input v-model="form.pool_id" :error="form.errors.pool_id" class="mt-6" label="养殖池编号" type="number" />
        <!-- 健康状况 -->
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
          更新
        </loading-button>
      </div>
    </form>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    TextInput,
    LoadingButton
  },
  props: {
    crocodile: Object
  },
  data() {
    return {
      form: this.$inertia.form({
        unique_id: this.crocodile.unique_id,
        rfid_tag: this.crocodile.rfid_tag,
        species_type: this.crocodile.species_type,
        gender: this.crocodile.gender,
        birth_date: this.crocodile.birth_date,
        genetic_lineage: this.crocodile.genetic_lineage,
        age: this.crocodile.age,
        weight: this.crocodile.weight,
        pool_id: this.crocodile.pool_id,
        health_status: this.crocodile.health_status
      }),
      successMessage: ''
    }
  },
  methods: {
    update() {
      // 前端基本验证
      if (!this.form.unique_id || !this.form.rfid_tag || !this.form.species_type || !this.form.gender || !this.form.birth_date || !this.form.genetic_lineage || !this.form.age || !this.form.weight || !this.form.pool_id ||!this.form.health_status) {
        this.form.setError('general', '所有字段均为必填项');
        return;
      }
      if (this.form.age < 0 || this.form.weight < 0) {
        this.form.setError('general', '年龄和体重必须为正数');
        return;
      }
      this.form.put(`/crocodile-management/basic-info/${this.crocodile.id}`, {
        onSuccess: () => {
          this.successMessage = '鳄鱼信息更新成功！';
          // 可以选择跳转到列表页
          // this.$inertia.visit('/crocodile-management/basic-info');
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