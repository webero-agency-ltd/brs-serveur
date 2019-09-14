import api from '../libs/api' ; 
import store from './store' ; 

class vosfacture extends store{
	constructor(){
		super();
		this.state = {
			teams : []
		}
	}
	//récupération de l'appli
	async find(){

	}
} 

export default new vosfacture() ;