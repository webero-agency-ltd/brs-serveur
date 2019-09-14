import api from '../libs/api' ; 
import model from './model' ; 

class option extends model{

	constructor(){
		super('option');
	}

	/*
	 * Récupération des option 
	*/
	async find( id ){
		let [ err , { data } ] = await api( '/api/option/'+ id )  ; 
		if ( err ) 
			return [ err , null ]
		this.state.lists = Object.assign({} , ...this.state.lists , { ...data }) ; 
		return [ null , this.state.lists ]
	}

	/*
	 * Création d'option  
	*/
	/*
		async create( body ){
			//BODY : { value et groupe? }
			let [ err , { data } ] = await api( '/api/option' , {
				method : 'POST' ,
				body : JSON.stringify( body )
			}); 
			if ( err ) 
				return [ err , null ]
			this.state.lists = Object.assign({} , ...this.state.lists , { ...data }  ) ; 
			return [ null , this.state.lists ]
		}
	*/

} 

export default option ;