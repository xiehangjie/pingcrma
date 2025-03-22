<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <Head title="圈舍管理" />
    <div class="max-w-7xl mx-auto">
      <!-- 标题和操作栏 -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
            圈舍管理
            <span class="text-emerald-600 ml-2">🏠</span>
          </h1>
          <p class="mt-2 text-gray-500">当前共 {{ enclosures.length }} 个圈舍信息</p>
        </div>
        <div class="flex space-x-4">
          <Link 
            class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                  hover:bg-gray-400 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
            href="#"
            @click.prevent="goBack"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            返回
          </Link>
          <button
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 
                   text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                   hover:from-emerald-600 hover:to-emerald-700 focus:ring-2 focus:ring-emerald-500 
                   focus:ring-offset-2 focus:outline-none"
            @click="showModal = true"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            添加圈舍
          </button>
        </div>
      </div>

      <!-- 数据加载状态 -->
      <div v-if="$page.loading" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <p class="mt-4 text-sm text-gray-500">正在加载圈舍信息...</p>
      </div>

      <!-- 数据加载错误 -->
      <div v-if="$page.error" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="mt-4 text-sm text-red-500">加载圈舍信息时出现错误，请稍后再试。</p>
      </div>

      <!-- 搜索框和按钮 -->
      <div class="flex items-center mb-4">
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="搜索圈舍编号、容量、养殖池类型" 
          class="p-2 border border-gray-300 rounded-md w-80 mr-2"
        >
        <button @click="autoAllocate" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 
                     text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                     hover:from-emerald-600 hover:to-emerald-700 focus:ring-2 focus:ring-emerald-500 
                     focus:ring-offset-2 focus:outline-none">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          自动分配圈舍
        </button>
      </div>

      <!-- 数据表格 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden ring-1 ring-black ring-opacity-5">
        <div class="overflow-y-auto max-h-[calc(100vh-280px)]"> <!-- 动态计算可视高度 -->
          <table class="min-w-full divide-y divide-gray-200 relative"> <!-- 添加relative定位 -->
            <thead class="bg-gray-50 sticky top-0 z-10"> <!-- 固定表头 -->
              <tr>
                <!-- 圈舍编号 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  圈舍编号
                </th>
                <!-- 容量 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  容量
                </th>
                <!-- 养殖池类型 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  养殖池类型
                </th>
                <!-- 当前鳄鱼数量 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  当前鳄鱼数量
                </th>
                <!-- 状态 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  状态
                </th>
                <!-- 鳄鱼唯一身份标识 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  鳄鱼唯一身份标识
                </th>
                <!-- 操作 -->
                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                  操作
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="enclosure in filteredEnclosures" :key="enclosure.id" class="hover:bg-gray-50 transition-colors cursor-pointer">
                <!-- 圈舍编号 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  {{ enclosure.pool_id }}
                </td>
                <!-- 容量 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  {{ enclosure.capacity }}
                </td>
                <!-- 养殖池类型 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  {{ enclosure.pool_type }}
                </td>
                <!-- 当前鳄鱼数量 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  {{ enclosure.crocodiles.length }}
                </td>
                <!-- 状态 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm" :class="getStatusColor(enclosure)">
                  {{ getStatusText(enclosure) }}
                </td>
                <!-- 鳄鱼唯一身份标识 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  <!-- 使用 pre 标签来保留换行符 -->
                  <pre>{{ getCrocodileIds(enclosure.crocodiles) }}</pre>
                </td>
                <!-- 操作 -->
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                  <button 
                    class="text-blue-500 hover:underline mr-2"
                    @click="editEnclosurePopup(enclosure)"
                  >
                    编辑
                  </button>
                  <button @click="deleteEnclosure(enclosure.id)" class="text-red-500 hover:underline">删除</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 空状态 -->
        <div v-if="!enclosures.length" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
          <p class="mt-4 text-sm text-gray-500">暂时没有圈舍信息，请添加圈舍信息。</p>
        </div>
      </div>

      <!-- 统计信息 -->
      <div class="mt-8">
        <p>总圈舍数量: {{ enclosures.length }}</p>
        <p>总鳄鱼数量: {{ getTotalCrocodileCount() }}</p>
        <p>平均每个圈舍的鳄鱼数量: {{ getAverageCrocodileCount() }}</p>
      </div>

      <!-- 添加圈舍弹窗背景 -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- 弹窗内容 -->
        <div class="max-w-md w-full bg-white p-6 rounded-md shadow-md relative">
          <button
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500"
            @click="showModal = false"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <form @submit.prevent="createEnclosure">
            <div class="mb-4">
              <label for="pool_id" class="block text-sm font-medium text-gray-700">圈舍编号</label>
              <input 
                type="text" 
                id="pool_id" 
                v-model="form.pool_id" 
                @input="validatePoolId"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              />
              <span v-if="form.errors.pool_id" class="text-red-500 text-sm">{{ form.errors.pool_id }}</span>
            </div>
            <div class="mb-4">
              <label for="capacity" class="block text-sm font-medium text-gray-700">容量</label>
              <input 
                type="number" 
                id="capacity" 
                v-model="form.capacity" 
                @input="validateCapacity"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              />
              <span v-if="form.errors.capacity" class="text-red-500 text-sm">{{ form.errors.capacity }}</span>
            </div>
            <div class="mb-4">
              <label for="pool_type" class="block text-sm font-medium text-gray-700">养殖池类型</label>
              <select 
                id="pool_type" 
                v-model="form.pool_type" 
                @change="validatePoolType"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              >
                <option value="小鳄鱼池">小鳄鱼池</option>
                <option value="成年鳄鱼池">成年鳄鱼池</option>
                <option value="繁殖池">繁殖池</option>
                <option value="病鳄隔离池">病鳄隔离池</option>
              </select>
              <span v-if="form.errors.pool_type" class="text-red-500 text-sm">{{ form.errors.pool_type }}</span>
            </div>
            <div class="flex space-x-4">
              <button 
                type="button"
                class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                       hover:bg-gray-400 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                @click="showModal = false"
              >
                取消
              </button>
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
            </div>
          </form>
        </div>
      </div>

      <!-- 编辑圈舍弹窗背景 -->
      <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- 弹窗内容 -->
        <div class="max-w-md w-full bg-white p-6 rounded-md shadow-md relative">
          <button
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500"
            @click="showEditModal = false"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <form @submit.prevent="updateEnclosure">
            <div class="mb-4">
              <label for="edit_pool_id" class="block text-sm font-medium text-gray-700">圈舍编号</label>
              <input 
                type="text" 
                id="edit_pool_id" 
                v-model="editForm.pool_id" 
                @input="validateEditPoolId"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              />
              <span v-if="editForm.errors.pool_id" class="text-red-500 text-sm">{{ editForm.errors.pool_id }}</span>
            </div>
            <div class="mb-4">
              <label for="edit_capacity" class="block text-sm font-medium text-gray-700">容量</label>
              <input 
                type="number" 
                id="edit_capacity" 
                v-model="editForm.capacity" 
                @input="validateEditCapacity"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              />
              <span v-if="editForm.errors.capacity" class="text-red-500 text-sm">{{ editForm.errors.capacity }}</span>
            </div>
            <div class="mb-4">
              <label for="edit_pool_type" class="block text-sm font-medium text-gray-700">养殖池类型</label>
              <select 
                id="edit_pool_type" 
                v-model="editForm.pool_type" 
                @change="validateEditPoolType"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                required
              >
                <option value="小鳄鱼池">小鳄鱼池</option>
                <option value="成年鳄鱼池">成年鳄鱼池</option>
                <option value="繁殖池">繁殖池</option>
                <option value="病鳄隔离池">病鳄隔离池</option>
              </select>
              <span v-if="editForm.errors.pool_type" class="text-red-500 text-sm">{{ editForm.errors.pool_type }}</span>
            </div>
            <div class="flex space-x-4">
              <button 
                type="button"
                class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 font-medium rounded-lg shadow-sm hover:shadow-md transition-all
                       hover:bg-gray-400 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                @click="showEditModal = false"
              >
                取消
              </button>
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
                保存修改
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

export default {
  components: {
    Head,
    Link
  },
  props: {
    enclosures: Array,
    crocodiles: Array
  },
  data() {
    return {
      showModal: false,
      showEditModal: false,
      form: this.$inertia.form({
        pool_id: '',
        capacity: '',
        pool_type: '',
        crocodile_id: null,
        enclosure_id: null
      }),
      editForm: this.$inertia.form({
        id: null,
        pool_id: '',
        capacity: '',
        pool_type: ''
      }),
      searchQuery: '',
      errorMessage: null
    }
  },
  computed: {
    filteredEnclosures() {
      const query = this.searchQuery.toLowerCase();
      return this.enclosures.filter(enclosure => {
        return (
          String(enclosure.pool_id).includes(query) ||
          String(enclosure.capacity).includes(query) ||
          String(enclosure.pool_type).toLowerCase().includes(query)
        );
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
    editEnclosurePopup(enclosure) {
      this.editForm.id = enclosure.id;
      this.editForm.pool_id = enclosure.pool_id;
      this.editForm.capacity = enclosure.capacity;
      this.editForm.pool_type = enclosure.pool_type;
      this.showEditModal = true;
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
      // 使用换行符拼接唯一身份标识
      return ids.join('\n');
    },
    goBack() {
      window.history.back();
    },
    createEnclosure() {
      this.form.post('/crocodile-management/enclosure', {
        onSuccess: () => {
          this.showModal = false;
          this.$inertia.visit('/crocodile-management/enclosure');
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    },
    updateEnclosure() {
      this.editForm.put(`/crocodile-management/enclosure/${this.editForm.id}`, {
        onSuccess: () => {
          this.showEditModal = false;
          this.$inertia.reload();
        },
        onError: (errors) => {
          console.error(errors);
        }
      });
    },
    validatePoolId() {
      if (!this.form.pool_id) {
        this.form.setError('pool_id', '圈舍编号不能为空');
      } else {
        this.form.clearErrors('pool_id');
      }
    },
    validateCapacity() {
      if (!this.form.capacity || isNaN(this.form.capacity) || this.form.capacity <= 0) {
        this.form.setError('capacity', '容量必须为正整数');
      } else {
        this.form.clearErrors('capacity');
      }
    },
    validatePoolType() {
      if (!this.form.pool_type) {
        this.form.setError('pool_type', '请选择养殖池类型');
      } else {
        this.form.clearErrors('pool_type');
      }
    },
    validateEditPoolId() {
      if (!this.editForm.pool_id) {
        this.editForm.setError('pool_id', '圈舍编号不能为空');
      } else {
        this.editForm.clearErrors('pool_id');
      }
    },
    validateEditCapacity() {
      if (!this.editForm.capacity || isNaN(this.editForm.capacity) || this.editForm.capacity <= 0) {
        this.editForm.setError('capacity', '容量必须为正整数');
      } else {
        this.editForm.clearErrors('capacity');
      }
    },
    validateEditPoolType() {
      if (!this.editForm.pool_type) {
        this.editForm.setError('pool_type', '请选择养殖池类型');
      } else {
        this.editForm.clearErrors('pool_type');
      }
    }
  }
}
</script>    