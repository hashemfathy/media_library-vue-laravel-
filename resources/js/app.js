import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import store from './store';

import Myside from './components/Myside'
import MediaLibrary from './app/mediaLibrary/components/MediaLibrary'


Vue.config.productionTip = false

const app = new Vue({
  el: '#app',
  store,
  components:{
      MediaLibrary,
      Myside,
  }
});
