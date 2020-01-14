// 从刚刚安装的库中加载数据
const addressData = {
  country: {
    1: 'Россия',
    2: 'Казахстан'
  },
  1: {
    11: 'Красноярск',
    12: 'Новосибирск'
  },
  2: {
   21: 'Город 1',
   22: 'Город 2'
  }
};
import _ from 'lodash';

Vue.component('select-district', {
  props: {
    initValue: {
      type: Array,
      default: () => ([]),
    }
  },
  data() {
    return {
      provinces: addressData['country'],
      cities: {},
      provinceId: '',
      cityId: '',
    };
  },
  watch: {
    provinceId(newVal) {
      if (!newVal) {
        this.cities = {};
        this.cityId = '';
        return;
      }
      this.cities = addressData[newVal];
      if (!this.cities[this.cityId]) {
        this.cityId = '';
      }
    },
    cityId() {
      this.$emit('change', [this.provinces[this.provinceId], this.cities[this.cityId]]);
    }
    // districtId() {
    //   this.$emit('change', [this.provinces[this.provinceId], this.cities[this.cityId], this.districts[this.districtId]]);
    // },
  },
  created() {
    this.setFromValue(this.initValue);
    console.log(addressData)
  },
  methods: {
    setFromValue(value) {
      value = _.filter(value);
      if (value.length === 0) {
        this.provinceId = '';
        return;
      }
      const provinceId = _.findKey(this.provinces, o => o === value[0]);
      if (!provinceId) {
        this.provinceId = '';
        return;
      }
      this.provinceId = provinceId;
      const cityId = _.findKey(addressData[provinceId], o => o === value[1]);
      if (!cityId) {
        this.cityId = '';
        return;
      }
      this.cityId = cityId;
    }
  }
});
