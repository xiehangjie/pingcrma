<template>
  <div>
    <Head title="添加鳄鱼信息" />
    <h1 class="mb-8 text-3xl font-bold">添加鳄鱼信息</h1>
    <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="store">
      <div class="px-10 py-12">
        <text-input v-model="form.name" :error="form.errors.name" class="mt-10" label="名称" type="text" autofocus autocapitalize="off" />
        <text-input v-model="form.age" :error="form.errors.age" class="mt-6" label="年龄" type="number" />
        <text-input v-model="form.weight" :error="form.errors.weight" class="mt-6" label="体重" type="number" step="0.01" />
        <text-input v-model="form.pool_id" :error="form.errors.pool_id" class="mt-6" label="养殖池编号" type="number" />
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
        pool_id: null
      })
    }
  },
  methods: {
    store() {
      this.form.post('/crocodiles')
    },
    cancel() {
      // 使用 history.back() 替代 this.$inertia.goBack()
      history.back();
    }
  }
}
</script>