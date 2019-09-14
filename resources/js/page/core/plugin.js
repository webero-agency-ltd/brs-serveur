import Vue from 'vue'; 
import Vuex from 'vuex'; 

Vue.use(Vuex)

import lang from '../plugin/lang'
Vue.use( lang );

import event from '../plugin/event'
Vue.use( event );

import model from '../plugin/model'
Vue.use( model );

export default Vue ; 
