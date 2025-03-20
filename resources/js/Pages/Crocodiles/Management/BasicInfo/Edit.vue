<template>
  <div class="max-w-3xl mx-auto">
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
      <div class="px-10 py-12 flex flex-wrap -mx-3">
        <!-- 左列 -->
        <div class="w-1/2 px-3">
          <!-- 唯一身份标识 -->
          <text-input 
            v-model="form.unique_id" 
            @input="validateUniqueId"
            :error="form.errors.unique_id" 
            class="mt-10" 
            label="唯一身份标识" 
            type="text"
            autofocus 
            autocapitalize="off" 
            placeholder="示例：CHN-860001234567-000001" 
          />

          <!-- RFID 电子标签 -->
          <text-input 
            v-model="form.rfid_tag" 
            @input="validateRfidTag"
            :error="form.errors.rfid_tag" 
            class="mt-6" 
            label="RFID 电子标签" 
            type="text" 
            placeholder="示例：E0040153-9A3B4C5D6E7F8A9B" 
          />

          <!-- 物种类型 -->
          <text-input 
            v-model="form.species_type" 
            @input="validateSpeciesType"
            :error="form.errors.species_type" 
            class="mt-6" 
            label="物种类型" 
            type="text"
          />

          <!-- 性别 -->
          <select-input 
            v-model="form.gender" 
            :error="form.errors.gender" 
            class="mt-6" 
            label="性别"
          >
            <option :value="null" />
            <option value="雄性">雄性</option>
            <option value="雌性">雌性</option>
          </select-input>

          <!-- 出生日期 -->
          <text-input 
            v-model="form.birth_date" 
            @input="validateBirthDate"
            :error="form.errors.birth_date" 
            class="mt-6" 
            label="出生日期" 
            type="date"
            :max="new Date().toISOString().split('T')[0]"
          />
        </div>

        <!-- 右列 -->
        <div class="w-1/2 px-3">
          <!-- 遗传谱系 -->
          <text-input 
            v-model="form.genetic_lineage" 
            :error="form.errors.genetic_lineage" 
            class="mt-10" 
            label="遗传谱系" 
            type="text" 
          />

          <!-- 年龄 -->
          <text-input 
            v-model="form.age" 
            @input="validateNumber('age', 0)"
            :error="form.errors.age" 
            class="mt-6" 
            label="年龄" 
            type="text"
            placeholder="请输入整数"
          />

          <!-- 体重 -->
          <text-input 
            v-model="form.weight" 
            @input="validateNumber('weight', 0)"
            :error="form.errors.weight" 
            class="mt-6" 
            label="体重" 
            type="text"
            placeholder="请输入数字（可包含小数）"
          />

          <!-- 养殖池编号 -->
          <text-input 
            v-model="form.pool_id" 
            @input="validatePoolId"
            :error="form.errors.pool_id" 
            class="mt-6" 
            label="养殖池编号" 
            type="text"
            placeholder="示例：860001234567"
            maxlength="12"
          />

          <!-- 健康状况 -->
          <select-input 
            v-model="form.health_status" 
            :error="form.errors.health_status" 
            class="mt-6" 
            label="健康状况"
          >
            <option :value="null" />
            <option value="健康">健康</option>
            <option value="患病">患病</option>
            <option value="康复中">康复中</option>
            <option value="亚健康">亚健康</option>
          </select-input>
        </div>
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
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    TextInput,
    SelectInput,
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
        age: this.crocodile.age.toString(),
        weight: this.crocodile.weight.toString(),
        pool_id: this.crocodile.pool_id.toString(),
        health_status: this.crocodile.health_status
      }),
      successMessage: ''
    }
  },
  methods: {
    // 即时验证方法
    validateUniqueId() {
      const regex = /^[A-Z]{3}-\d{12}-\d{6}$/;
      if (!regex.test(this.form.unique_id)) {
        this.form.setError('unique_id', '格式示例：CHN-860001234567-000001');
      } else {
        this.form.clearErrors('unique_id');
      }
    },

    validateRfidTag() {
      const regex = /^[A-Z0-9]{8}-[A-Z0-9]{16}$/;
      if (!regex.test(this.form.rfid_tag)) {
        this.form.setError('rfid_tag', '格式示例：E0040153-9A3B4C5D6E7F8A9B');
      } else {
        this.form.clearErrors('rfid_tag');
      }
    },

    validateSpeciesType() {
      const regex = /^[\u4e00-\u9fa5a-zA-Z]+$/;
      // 过滤非法字符
      this.form.species_type = this.form.species_type.replace(/[^\u4e00-\u9fa5a-zA-Z]/g, '');
      
      if (!regex.test(this.form.species_type)) {
        this.form.setError('species_type', '仅允许中文/英文字母');
      } else {
        this.form.clearErrors('species_type');
      }
    },

    validateNumber(field, min = 0) {
      // 保留数字和小数点
      this.form[field] = this.form[field]
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');

      // 验证数字有效性
      const value = parseFloat(this.form[field]);
      if (isNaN(value) || value < min) {
        this.form.setError(field, `必须大于等于 ${min}`);
      } else {
        this.form.clearErrors(field);
      }
    },

    validatePoolId() {
      // 过滤非数字字符
      this.form.pool_id = this.form.pool_id.replace(/[^0-9]/g, '');
      
      // 验证长度
      if (this.form.pool_id.length !== 12) {
        this.form.setError('pool_id', '必须是12位数字');
      } else {
        this.form.clearErrors('pool_id');
      }
    },

    validateBirthDate() {
      const today = new Date().toISOString().split('T')[0];
      if (this.form.birth_date > today) {
        this.form.setError('birth_date', '日期不能超过当前时间');
      } else {
        this.form.clearErrors('birth_date');
      }
    },

    // 提交表单
    update() {
      // 提交前最终验证
      const requiredFields = [
        'unique_id', 'rfid_tag', 'species_type', 
        'gender', 'birth_date', 'genetic_lineage',
        'age', 'weight', 'pool_id', 'health_status'
      ];

      const hasEmptyField = requiredFields.some(field => {
        if (field === 'birth_date') return !this.form[field];
        return !this.form[field].toString().trim();
      });

      if (hasEmptyField) {
        this.form.setError('general', '所有字段均为必填项');
        return;
      }

      // 其他验证逻辑保持不变...
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

<style scoped>
.input-error {
  @apply border-red-500 focus:ring-red-500 focus:border-red-500;
}

.input-valid {
  @apply border-green-500 focus:ring-green-500 focus:border-green-500;
}
</style>