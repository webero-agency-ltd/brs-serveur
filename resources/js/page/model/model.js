import api from '../libs/api' ;

let $toparams = function( obj ){
	var str = "";
	for (var key in obj) {
	    if (str != "") {
	        str += "&";
	    }
	    str += key + "=" + encodeURIComponent(obj[key]);
	}
	return str ;
}

let index = async function( query = {} ){
	let q = $toparams( query )
	let url = '/api/'+this.name+ (q?'?'+q:'') ;  
	let [ err , res ] = await api( url ) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

let show = async function( id , query = {} ){
	let q = $toparams( query )
	let url = '/api/'+this.name+'/'+id + (q?'?'+q:'') ;;  
	let [ err , res ] = await api( url ) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

let get = async function( query = {} ){
	let q = $toparams( query )
	let url = '/api/'+this.name + (q?'?'+q:'') ;;  
	let [ err , res ] = await api( url ) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

let bodyFormat = function( data ){
	let formData = new FormData();
	let keys = Object.keys( data ) ; 
	for( let key of keys ){
		formData.append( key , keys[key] );
	}
    return formData ; 
}

let store = async function( body , isfile = false ){
	if( this.beforeStore ){
		body = this.beforeStore( body ) ;
	}
	//option si l'on veux envoyer des fichiers ect ... 
	let url = '/api/'+this.name ;  
	let [ err , res ] = await api( url ,{
		method: "POST",
		body : isfile?bodyFormat(body):JSON.stringify(body) ,
	} , !isfile ) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

let update = async function( id , body , isfile = false ){
	if( this.beforeStore ){
		body = this.beforeStore( body ) ;
	}
	//option si l'on veux envoyer des fichiers ect ... 
	let url = '/api/'+this.name+'/'+id;  
	let [ err , res ] = await api( url ,{
		method: "PUT",
		body : isfile?bodyFormat(body):JSON.stringify(body) ,
	} , !isfile ) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

let destroy  = async function( id ){
	let url = '/api/'+this.name+'/'+id;  
	let [ err , res ] = await api( url ,{
		method : 'DELETE' 
	}) ;
	if ( err ) 
		return [ err , null ]
	return [ null , res ]
}

class storeclass {

	constructor( name , methods = [] ){

		this.event = {}
		this.name = name;
		//initialisation des fonctions des classe 
		if( methods.indexOf( 'index' ) !== -1  )
			this['index'] = index ;
		if( methods.indexOf( 'show' ) !== -1  )
			this['show'] = show ;
		if( methods.indexOf( 'store' ) !== -1  )
			this['store'] = store ;
		if( methods.indexOf( 'update' ) !== -1  )
			this['update'] = update ;
		if( methods.indexOf( 'destroy' ) !== -1  )
			this['destroy'] = destroy ;
		if( methods.indexOf( 'get' ) !== -1  )
			this['get'] = get ;

		if( methods.length == 0 ){
			this['index'] = index ;
			this['show'] = show ;
			this['store'] = store ;
			this['update'] = update ;
			this['destroy'] = destroy ;
			this['get'] = get ;
		}

	}

	$on( event , cbl ){
		if ( this.event[event] ) 
			this.event[event].push( cbl )
		else{
			this.event[event] = [] ; 
			this.event[event].push( cbl )
		}
	}

	$emit( event , data ){
		if ( this.event[event] ) {
			this.event[event].forEach(function( item ){
				item( data )
			})
		}
	}

};

storeclass.prototype.$extends = function ( { name , enpoint } , method = [] ) {
	this[name] = new storeclass( this.name+'/'+enpoint , method ) ; 
}

export default storeclass ; 