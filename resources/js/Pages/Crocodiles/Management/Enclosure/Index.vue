<template>
  <div>
    <Head title="圈舍管理" />
    <h1 class="mb-8 text-3xl font-bold">圈舍管理</h1>
    <!-- 搜索框 -->
    <input type="text" v-model="searchQuery" placeholder="搜索圈舍编号" class="mb-4 p-2 border border-gray-300 rounded-md">
    <button @click="autoAllocate" class="bg-emerald-500 text-white px-6 py-3 rounded-md font-bold hover:bg-emerald-600 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-opacity-50 ml-auto">
      自动分配圈舍
    </button>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            圈舍编号
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            容量
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            当前鳄鱼数量
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            状态
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            鳄鱼唯一身份标识
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
            操作
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="enclosure in filteredEnclosures" :key="enclosure.id">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ enclosure.pool_id }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <input type="number" v-model="enclosure.capacity" min="0" @change="updateEnclosureCapacity(enclosure.id, enclosure.capacity)" class="border border-gray-300 rounded-md p-1">
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ enclosure.crocodiles.length }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <span :class="getStatusColor(enclosure)">
              {{ getStatusText(enclosure) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ getCrocodileIds(enclosure.crocodiles) }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <button @click="editEnclosure(enclosure.id)" class="text-blue-500 hover:underline mr-2">编辑</button>
            <button @click="deleteEnclosure(enclosure.id)" class="text-red-500 hover:underline">删除</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- 手动分配表单 -->
    <form @submit.prevent="allocate">
      <select v-model="form.crocodile_id">
        <option v-for="crocodile in crocodiles" :key="crocodile.id" :value="crocodile.id">
          {{ crocodile.unique_id }}
        </option>
      </select>
      <select v-model="form.enclosure_id">
        <option v-for="enclosure in enclosures" :key="enclosure.id" :value="enclosure.id">
          {{ enclosure.pool_id }}
        </option>
      </select>
      <span v-if="!form.crocodile_id || !form.enclosure_id" class="text-red-500 ml-2">请选择鳄鱼和圈舍</span>
      <button type="submit">手动分配</button>
    </form>
    <!-- 统计信息 -->
    <div class="mt-8">
      <p>总圈舍数量: {{ enclosures.length }}</p>
      <p>总鳄鱼数量: {{ getTotalCrocodileCount() }}</p>
      <p>平均每个圈舍的鳄鱼数量: {{ getAverageCrocodileCount() }}</p>
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
  props: {
    enclosures: Array,
    crocodiles: Array
  },
  data() {
    return {
      form: this.$inertia.form({
        crocodile_id: null,
        enclosure_id: null
      }),
      searchQuery: '',
      errorMessage: null
    }
  },
  computed: {
    filteredEnclosures() {
      return this.enclosures.filter(enclosure => {
        return String(enclosure.pool_id).includes(this.searchQuery);
      });
    }
  },
  methods: {
    allocate() {
      if (!this.form.crocodile_id || !this.form.enclosure_id) {
        return;
      }
      this.form.post('/crocodile-management/enclosure/allocate', {
        onSuccess: () => {
          this.$inertia.reload();
        },
        onError: (errors) => {
          this.errorMessage = errors.message || '分配失败，请稍后重试';
        }
      });
    },
    autoAllocate() {
      this.$inertia.post('/crocodile-management/enclosure/auto-allocate', {
        onSuccess: () => {
          this.$inertia.reload();
        },
        onError: (errors) => {
          this.errorMessage = errors.message || '自动分配失败，请稍后重试';
        }
      });
    },
    getStatusColor(enclosure) {
      const currentCount = enclosure.crocodiles.length;
      if (currentCount > enclosure.capacity) {
        return 'text-red-500';
      } else if (currentCount === enclosure.capacity) {
        return 'text-yellow-500';
      } else if (currentCount === 0) {
        return 'text-gray-500';
      } else {
        return 'text-green-500';
      }
    },
    getStatusText(enclosure) {
      const currentCount = enclosure.crocodiles.length;
      if (currentCount > enclosure.capacity) {
        return '超载';
      } else if (currentCount === enclosure.capacity) {
        return '临界';
      } else if (currentCount === 0) {
        return '空闲';
      } else {
        return '正常';
      }
    },
    editEnclosure(enclosureId) {
      // 这里可以实现编辑圈舍信息的逻辑，例如跳转到编辑页面
      console.log(`编辑圈舍 ID: ${enclosureId}`);
    },
    deleteEnclosure(enclosureId) {
      if (confirm('确定要删除这个圈舍吗？')) {
        this.$inertia.delete(`/crocodile-management/enclosure/${enclosureId}`, {
          onSuccess: () => {
            this.$inertia.reload();
          },
          onError: (errors) => {
            this.errorMessage = errors.message || '删除失败，请稍后重试';
          }
        });
      }
    },
    getTotalCrocodileCount() {
      return this.enclosures.reduce((total, enclosure) => {
        return total + enclosure.crocodiles.length;
      }, 0);
    },
    getAverageCrocodileCount() {
      if (this.enclosures.length === 0) {
        return 0;
      }
      return (this.getTotalCrocodileCount() / this.enclosures.length).toFixed(2);
    },
    updateEnclosureCapacity(enclosureId, capacity) {
      this.$inertia.put(`/crocodile-management/enclosure/${enclosureId}/update-capacity`, { capacity }, {
        onSuccess: () => {
          this.$inertia.reload();
        },
        onError: (errors) => {
          this.errorMessage = errors.message || '更新圈舍容量失败，请稍后重试';
        }
      });
    },
    getCrocodileIds(crocodiles) {
      if (crocodiles.length === 0) {
        return '无';
      }
      const ids = crocodiles.map(crocodile => crocodile.unique_id);
      if (ids.some(id => !id)) {
        console.error('部分鳄鱼唯一身份标识为空', crocodiles);
      }
      return ids.filter(id => id).join(', ');
    }
  }
}
</script>