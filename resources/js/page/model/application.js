import model from './model' ; 
import lang from '../libs/lang' ; 

class application extends model{

	constructor(){
		super( 'application' );
		this.$extends( { name : 'initCard' , enpoint : 'cards/trello' } , ['find'], null ) ; 
	}

	//formatage donner avant store 
	beforeStore( data ){
		let newapp = Object.assign({} , data ) ; 
		return Object.entries(newapp).reduce((a,[k,v]) => (v ? {...a, [k]:v} : a), {})  ;
	} 

} 

export default application;