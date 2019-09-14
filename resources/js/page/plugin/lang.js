import Vue from 'vue';
import lang from '../libs/lang';

let plugLang = {};
plugLang.install = function (Vue, options) {
  	Vue.prototype.$lang = lang ; 
}

Vue.use(plugLang);

export default plugLang ; 