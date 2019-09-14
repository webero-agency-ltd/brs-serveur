import Vuex from 'vuex' ; 

let state =  {
    lists: [], 
};

const store = new Vuex.Store({
	state ,
	mutations: {
	    async addSyncContact( store , data ){
	    	return this.state.lists = data ; 
	    },
	    startSyncContact( store , index ){
	        this.state.lists[index].start = true ;
	    },
	    stopSyncContact( store , index ){
            this.state.lists[index].start = false ;
	    },
	    progressSyncContact( store , {index , progress } ){
            this.state.lists[index].progress = progress ;
        }
	},
	getters: {},
})

export default store ; 