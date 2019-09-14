
export default {
	
	bind : function (el, binding, vnode){ 
		const vm = vnode.context ;
		vm.$nextTick(() => {
			//changer placeholder s'il existe 
			//écouter le changement donc si on fait le changement et qu'il y a des erreur, alors on reste l'erreur 			
			let element = $(el) ; 
			let out = null ; 
			element.on('input',(e,data)=>{
				clearTimeout( out )
				out = setTimeout( () => {
					let { store } = vm ; 
					if( store.state.error [binding.value] != undefined )
						store.state.error [binding.value] = null ; 
				}, 400);
			})
		})
	},

}
