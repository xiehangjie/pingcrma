<template>
  <div class="max-w-3xl mx-auto">
    <Head title="添加鳄鱼信息" />
    <h1 class="mb-8 text-3xl font-bold">添加鳄鱼信息</h1>

    <!-- 成功提示 -->
    <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">成功！</strong>
      <span class="block sm:inline">{{ successMessage }}</span>
    </div>

    <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="store">
      <div class="px-10 py-12 flex flex-wrap -mx-3">
        <!-- 左列 -->
        <div class="w-1/2 px-3">
          <!-- 唯一身份标识 -->
          <text-input 
            v-model="form.unique_id" 
            @blur="validateUniqueId"
            :error="form.errors.unique_id" 
            class="mt-10" 
            label="唯一身份标识" 
            type="text"
            autofocus 
            autocapitalize="off" 
            placeholder="示例：CHN-860001234567-000001" 
            :class="{ 'input-error': form.errors.unique_id, 'input-valid': !form.errors.unique_id && form.unique_id }"
          />

          <!-- RFID 电子标签 -->
          <text-input 
            v-model="form.rfid_tag" 
            @blur="validateRfidTag"
            :error="form.errors.rfid_tag" 
            class="mt-6" 
            label="RFID 电子标签" 
            type="text" 
            placeholder="示例：E0040153-9A3B4C5D6E7F8A9B" 
            :class="{ 'input-error': form.errors.rfid_tag, 'input-valid': !form.errors.rfid_tag && form.rfid_tag }"
          />

          <!-- 物种类型 -->
          <text-input 
            v-model="form.species_type" 
            @blur="validateSpeciesType"
            :error="form.errors.species_type" 
            class="mt-6" 
            label="物种类型" 
            type="text"
            :class="{ 'input-error': form.errors.species_type, 'input-valid': !form.errors.species_type && form.species_type }"
          />

          <!-- 性别 -->
          <select-input 
            v-model="form.gender" 
            :error="form.errors.gender" 
            class="mt-6" 
            label="性别"
            :class="{ 'input-error': form.errors.gender, 'input-valid': !form.errors.gender && form.gender }"
          >
            <option :value="null" />
            <option value="雄性">雄性</option>
            <option value="雌性">雌性</option>
          </select-input>

          <!-- 出生日期 -->
          <text-input 
            v-model="form.birth_date" 
            @blur="validateBirthDate"
            :error="form.errors.birth_date" 
            class="mt-6" 
            label="出生日期" 
            type="date"
            :max="new Date().toISOString().split('T')[0]"
            :class="{ 'input-error': form.errors.birth_date, 'input-valid': !form.errors.birth_date && form.birth_date }"
          />
        </div>

        <!-- 右列 -->
        <div class="w-1/2 px-3">
          <!-- 遗传谱系 -->
          <text-input 
            v-model="form.genetic_lineage" 
            @blur="validateRequiredField('genetic_lineage')"
            :error="form.errors.genetic_lineage" 
            class="mt-10" 
            label="遗传谱系" 
            type="text" 
            :class="{ 'input-error': form.errors.genetic_lineage, 'input-valid': !form.errors.genetic_lineage && form.genetic_lineage }"
          />

          <!-- 年龄 -->
          <text-input 
            v-model="form.age" 
            @blur="validateNumber('age', 0)"
            :error="form.errors.age" 
            class="mt-6" 
            label="年龄" 
            type="text"
            placeholder="请输入整数"
            :class="{ 'input-error': form.errors.age, 'input-valid': !form.errors.age && form.age }"
          />

          <!-- 体重 -->
          <text-input 
            v-model="form.weight" 
            @blur="validateNumber('weight', 0)"
            :error="form.errors.weight" 
            class="mt-6" 
            label="体重" 
            type="text"
            placeholder="请输入数字（可包含小数）"
            :class="{ 'input-error': form.errors.weight, 'input-valid': !form.errors.weight && form.weight }"
          />

          <!-- 养殖池编号 -->
          <text-input 
            v-model="form.pool_id" 
            @blur="validatePoolId"
            :error="form.errors.pool_id" 
            class="mt-6" 
            label="养殖池编号" 
            type="text"
            placeholder="示例：860001234567"
            maxlength="12"
            :class="{ 'input-error': form.errors.pool_id, 'input-valid': !form.errors.pool_id && form.pool_id }"
          />

          <!-- 健康状况 -->
          <select-input 
            v-model="form.health_status" 
            @blur="validateRequiredField('health_status')"
            :error="form.errors.health_status" 
            class="mt-6" 
            label="健康状况"
            :class="{ 'input-error': form.errors.health_status, 'input-valid': !form.errors.health_status && form.health_status }"
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
          保存
        </loading-button>
      </div>
    </form>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

const ERROR_MESSAGES = {
  unique_id: '格式示例：CHN-860001234567-000001',
  rfid_tag: '格式示例：E0040153-9A3B4C5D6E7F8A9B',
  species_type: '仅允许文字',
  required: '该字段为必填项',
  pool_id: '必须是12位数字',
  birth_date: '日期不能超过当前时间',
  number: '必须是大于等于 {min} 的数字'
};

export default {
  components: {
    Head,
    TextInput,
    SelectInput,
    LoadingButton
  },
  data() {
    return {
      form: this.$inertia.form({
        unique_id: '',
        rfid_tag: '',
        species_type: '',
        gender: '',
        birth_date: '',
        genetic_lineage: '',
        age: '',
        weight: '',
        pool_id: '',
        health_status: ''
      }),
      successMessage: ''
    }
  },
  methods: {
    setError(field, message) {
      this.form.setError(field, message);
    },
    clearError(field) {
      this.form.clearErrors(field);
    },
    // 即时验证方法
    validateUniqueId() {
      if (this.form.unique_id) {
        const regex = /^[A-Z]{3}-\d{12}-\d{6}$/;
        if (!regex.test(this.form.unique_id)) {
          this.setError('unique_id', ERROR_MESSAGES.unique_id);
        } else {
          this.clearError('unique_id');
        }
      } else {
        this.setError('unique_id', ERROR_MESSAGES.required);
      }
    },

    validateRfidTag() {
      if (this.form.rfid_tag) {
        const regex = /^[A-Z0-9]{8}-[A-Z0-9]{16}$/;
        if (!regex.test(this.form.rfid_tag)) {
          this.setError('rfid_tag', ERROR_MESSAGES.rfid_tag);
        } else {
          this.clearError('rfid_tag');
        }
      } else {
        this.setError('rfid_tag', ERROR_MESSAGES.required);
      }
    },

    validateSpeciesType() {
      if (this.form.species_type) {
        const regex = /^[\u4e00-\u9fa5a-zA-Z]+$/;
        // 过滤非法字符
        this.form.species_type = this.form.species_type.replace(/[^\u4e00-\u9fa5a-zA-Z]/g, '');

        if (!regex.test(this.form.species_type)) {
          this.setError('species_type', ERROR_MESSAGES.species_type);
        } else {
          this.clearError('species_type');
        }
      } else {
        this.setError('species_type', ERROR_MESSAGES.required);
      }
    },

    validateNumber(field, min = 0) {
      if (this.form[field]) {
        // 保留数字和小数点
        this.form[field] = this.form[field]
          .replace(/[^0-9.]/g, '')
          .replace(/(\..*)\./g, '$1');

        // 验证数字有效性
        const value = parseFloat(this.form[field]);
        if (isNaN(value) || value < min) {
          this.setError(field, ERROR_MESSAGES.number.replace('{min}', min));
        } else {
          this.clearError(field);
        }
      } else {
        this.setError(field, ERROR_MESSAGES.required);
      }
    },

    validatePoolId() {
      if (this.form.pool_id) {
        // 过滤非数字字符
        this.form.pool_id = this.form.pool_id.replace(/[^0-9]/g, '');

        // 验证长度
        if (this.form.pool_id.length !== 12) {
          this.setError('pool_id', ERROR_MESSAGES.pool_id);
        } else {
          this.clearError('pool_id');
        }
      } else {
        this.setError('pool_id', ERROR_MESSAGES.required);
      }
    },

    validateBirthDate() {
      if (this.form.birth_date) {
        const today = new Date().toISOString().split('T')[0];
        if (this.form.birth_date > today) {
          this.setError('birth_date', ERROR_MESSAGES.birth_date);
        } else {
          this.clearError('birth_date');
        }
      } else {
        this.setError('birth_date', ERROR_MESSAGES.required);
      }
    },

    validateRequiredField(field) {
      if (!this.form[field] || !this.form[field].toString().trim()) {
        this.setError(field, ERROR_MESSAGES.required);
      } else {
        this.clearError(field);
      }
    },

    // 提交表单
    store() {
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
        requiredFields.forEach(field => {
          if (!this.form[field].toString().trim()) {
            this.setError(field, ERROR_MESSAGES.required);
          }
        });
        return;
      }

      // 其他验证逻辑保持不变...
      this.form.post('/crocodile-management/basic-info', {
        onSuccess: () => {
          this.successMessage = '鳄鱼信息添加成功！';
          // 清空表单
          this.form.reset();
          this.form.clearErrors();
        },
        onError: (errors) => {
          // 处理服务器返回的错误
          Object.keys(errors).forEach(field => {
            this.setError(field, errors[field][0]);
          });
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