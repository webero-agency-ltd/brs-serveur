import Vue from 'vue';
//import option from '../model/option';

let plugModule = {};

plugModule.install = function (Vue, options) {
	Vue.prototype.$model = { 
		
	};
}

Vue.use(plugModule);

export default plugModule ; 