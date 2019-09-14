<template>
    <b-form 
        :store="store" 
        :event="'MobileCreate'" 
        :layout="'horizontal'" 
        :model="'mobile'"
        @ok="ok"
        :label="'admin create mobile'">
        <b-form-item :champ="'name'" >
            <a-input v-gmodel="'name'" v-model="form.name"/> 
        </b-form-item>
        <b-form-item :champ="'trello'" >
            <a-select v-gmodel="'trello'" v-model="form.trello">
                <a-select-option v-for="item in trello" :key="item.application.id" :value="item.application.id">
                    {{item.application.name}}
                </a-select-option>
            </a-select>
        </b-form-item>
        <b-form-item :champ="'infusionsoft'" >
            <a-select v-gmodel="'infusionsoft'" v-model="form.infusionsoft">
                <a-select-option v-for="item in infusionsoft" :key="item.application.id" :value="item.application.id">
                    {{item.application.name}}
                </a-select-option>
            </a-select>
        </b-form-item>
    </b-form>
</template>
<script>
	 
    import form from '../../store/form' ; 
	
	export default {
		props : [], 
		data(){
            return {
                infusionsoft : [] , 
                trello : [] , 
                store : null , 
            }
        },
        methods : {
            init : async function () {
                let a = new this.application() ; 
                let [ err , { data }] = await a.get({ all : true }) ; 
                if( data.length ){
                    this.infusionsoft = data.filter( e => e.application.type == "infusionsoft" )
                    this.trello = data.filter( e => e.application.type == "trello" )
                }
            },
            //la création est OK, on fait cette actions 
            ok( { data } ){
                this.emit('closemodale') ; 
                this.emit('MobileCreateCloseModale') ;
            }
        },
        computed : {
            form : function (argument) {
                if( this.store )
                return this.store.state.form
            }
        },
		created(){
            this.store = form({ name : '' , infusionsoft : '' , trello : '' }) ; 
            this.init()
		}
	}
</script>