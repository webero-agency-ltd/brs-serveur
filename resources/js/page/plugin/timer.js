import Vue from 'vue';
import lang from '../libs/lang';
import moment from 'moment'
moment.locale('fr') ; 

//@todo : capturer si le temps d'un élément doivent etre affichier tout les heurs, tout les minute, ou tout les jours 

let plugTimes = {};

let interval = null ; 
let listeners = [] ;

let timer = function ( cbl ) {
	interval = setInterval(function() {
		for (var i = 0; i < listeners.length; i++) {
			listeners[i].cbl( moment( listeners[i].time ).fromNow() )
		}
	}, 60000);
}

plugTimes.install = function (Vue, options) {

  	Vue.prototype.timer = function () {
  		if( !interval )
			timer() ; 
  	}

  	Vue.prototype.timerStop = function () {
		clearInterval( interval )
  	}

  	Vue.prototype.timerOn = function ( id , time , cbl ) {
  		this.timer() ;
		listeners.push( { id , time , cbl } )
		cbl( moment( time ).fromNow() ) ; 
  	}

  	Vue.prototype.timerReset = function ( cbl ) {
		listeners = [] ; 
		this.timerStop() ; 
  	}

}

Vue.use(plugTimes);

export default plugTimes ; 