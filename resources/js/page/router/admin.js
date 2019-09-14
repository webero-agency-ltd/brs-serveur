import Vue from 'vue';
import vueRouter from 'vue-router';

Vue.use(vueRouter);

import Home from '../page/admin/index';
import Application from '../page/admin/application';
import Synconisation from '../page/admin/synconisation';
import User from '../page/admin/user';

let $application = document.getElementById('application') ; 

let router = new vueRouter({
	mode: 'history',
	base : $application.getAttribute('data-base'),
	routes : [
		{ name: 'Home', path : '/', component : Home },
		{ name: 'Application', path : '/application', component : Application },
		{ name: 'Syncronisation', path : '/syncronisation', component : Synconisation },
		{ name: 'User', path : '/user', component : User },
		{ path : '*', redirect : '/'},
	],
})

export default router ; 