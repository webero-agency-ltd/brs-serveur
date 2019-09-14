import Vuex from 'vuex' ; 

export default function( data ){

	let state =  {
	    form : {}, 
	    error : {},
	}; 

	state.form = Object.assign( {} , data ) ; 
	//state.error = Object.assign( {} , data ) ; 
	return new Vuex.Store({
		state ,
		mutations: {
		    changeValue( store , { name , value } ){
		    	if( this.state.form[name] != undefined )
	            	this.state.form[name] = value ;
	        },
	        addError( store , data ){
	        	this.state.error = Object.assign({} , data.errors )
	        }
		},
		getters: {},
	})
} ; 