import Vue from 'vue';
import vueRouter from 'vue-router';
Vue.use(vueRouter);

//les différent routes des différents applications 
import Admin from './admin';

let Pages = { Admin } ; 

export default function( page ){
	
	let routes = [] ;
    for( let item of window.Pages ){
    	if( Pages[page][item.name] ){
    		routes = [ ...routes , Object.assign({},item,{component:Pages[page][item.name]}) ]
    	}
    }
    routes.push({ path : '*', redirect : '/'})
	let $application = document.getElementById('application') ; 
	return new vueRouter({
		mode: 'history',
		base : $application.getAttribute('data-base'),
		routes ,
	});

}