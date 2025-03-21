<template>
  <div>
    <Head title="圈舍管理" />
    <h1 class="mb-8 text-3xl font-bold">圈舍管理</h1>
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
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="enclosure in enclosures" :key="enclosure.id">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ enclosure.enclosure_number }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ enclosure.capacity }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ enclosure.crocodiles.length }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <span :class="getStatusColor(enclosure)">
              {{ getStatusText(enclosure) }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
    <form @submit.prevent="allocate">
      <select v-model="form.crocodile_id">
        <option v-for="crocodile in crocodiles" :key="crocodile.id" :value="crocodile.id">
          {{ crocodile.unique_id }}
        </option>
      </select>
      <select v-model="form.enclosure_id">
        <option v-for="enclosure in enclosures" :key="enclosure.id" :value="enclosure.id">
          {{ enclosure.enclosure_number }}
        </option>
      </select>
      <button type="submit">手动分配</button>
    </form>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'

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
      })
    }
  },
  methods: {
    allocate() {
      this.form.post('/crocodile-management/enclosure/allocate', {
        onSuccess: () => {
          this.$inertia.reload();
        }
      });
    },
    autoAllocate() {
      this.$inertia.post('/crocodile-management/enclosure/auto-allocate', {
        onSuccess: () => {
          this.$inertia.reload();
        }
      });
    },
    getStatusColor(enclosure) {
      const currentCount = enclosure.crocodiles.length;
      if (currentCount > enclosure.capacity) {
        return 'text-red-500';
      } else if (currentCount === enclosure.capacity) {
        return 'text-yellow-500';
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
      } else {
        return '正常';
      }
    }
  }
}
</script>