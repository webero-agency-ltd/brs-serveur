import api from '../libs/api' ; 
import model from './model' ; 

class infusionsoft extends model{
	
	constructor(){
		super('infusionsoft');
		this.$extends( { name : 'readycontact' , enpoint : 'readycontact' } , ['get'], null ) ; 
	}
	
	async fetchContact( callback ){
		let err , data ; 
		do{
			[ err , data ] = await api( '/api/infusionsoft/fetchContact' ) ;
			callback?callback( data ):'' ; 
		}while( !data || !data.success )
		if ( err ) 
			return [ err , null ]
		return [ null , true ]
	}

} 

export default infusionsoft ;