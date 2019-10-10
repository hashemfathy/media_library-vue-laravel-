import Vue from 'vue'
import Vuex from 'vuex'
import store from '../app/store'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        mediaLibrary: store.MediaLibrary,
    }
})
