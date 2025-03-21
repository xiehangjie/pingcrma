<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <Head title="添加圈舍" />
    <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-8">
        添加圈舍
      </h1>
      <form @submit.prevent="createEnclosure">
        <div class="mb-4">
          <label for="pool_id" class="block text-sm font-medium text-gray-700">圈舍编号</label>
          <input 
            type="text" 
            id="pool_id" 
            v-model="form.pool_id" 
            class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
            required
          />
        </div>
        <div class="mb-4">
          <label for="capacity" class="block text-sm font-medium text-gray-700">容量</label>
          <input 
            type="number" 
            id="capacity" 
            v-model="form.capacity" 
            class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
            required
          />
        </div>
        <div class="mb-4">
          <label for="pool_type" class="block text-sm font-medium text-gray-700">养殖池类型</label>
          <input 
            type="text" 
            id="pool_type" 
            v-model="form.pool_type" 
            class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
            required
          />
        </div>
        <button 
          type="submit" 
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 
                 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                 hover:from-emerald-600 hover:to-emerald-700 focus:ring-2 focus:ring-emerald-500 
                 focus:ring-offset-2 focus:outline-none"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          提交
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

export default {
  components: {
    Head
  },
  data() {
    return {
      form: this.$inertia.form({
        pool_id: '',
        capacity: '',
        pool_type: ''
      })
    }
  },
  methods: {
    createEnclosure() {
      this.form.post('/crocodile-management/enclosure', {
        onSuccess: () => {
          this.$inertia.visit('/crocodile-management/enclosure');
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    }
  }
}
</script>