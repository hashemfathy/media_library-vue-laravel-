import Vue from 'vue'
import App from './components/App.vue'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import store from './store';

Vue.config.productionTip = false


// new Vue({
//   render: h => h(App),
//   store
// }).$mount('#app')

const app = new Vue({
  el: '#app',
  store,
  components:{
      App,
  }
});
