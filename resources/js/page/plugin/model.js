import Vue from 'vue';
import application from '../model/application';
import infusionsoft from '../model/infusionsoft';
import option from '../model/option';

let plugModule = {};

plugModule.install = function (Vue, options) {
	Vue.prototype.$model = { 
		application , 
		option , 
		infusionsoft 
	};
}

Vue.use(plugModule);

export default plugModule ; 