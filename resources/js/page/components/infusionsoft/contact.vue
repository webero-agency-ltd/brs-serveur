<template>
    <b-form 
        :event="'InfusionsoftContact'" 
        :model="'application'"
        :layout="'vertical'"
        :label="'admin create application'"
        :store="store"
        @ok="ok">
        <b-form-item :champ="'name'">
            <a-input 
                v-model="form.name"
                :placeholder="$lang('admin application vosfactures name')" /> 
        </b-form-item>
        <a-button 
            @click="emit('ApplicationCreateInfusionsoft')">
            {{$lang('application vosfactures submit')}}
        </a-button>
    </b-form>
</template>
<script>

    import form from '../../store/form' ; 

	export default {
		props : ['ifs'], 
		data(){
            return {
                temp : {} ,
                store : null ,
            }
        },
        computed: {
            form : function (argument) {
                if( this.store )
                return this.store.state.form
            },
            application : function (argument) {
                if( this.ifs )
                    return this.ifs ; 
                else if( this.temp )
                    return this.temp
                return {}
            }
        },
        methods : {
            //la création est OK, on fait cette actions 
            ok( data ){
                let win = window.open( data.redirect , '_blank');
                return win.focus();
            },
            init(){
                //s'il y a des valeur / defaut, on fait la récupération ICI
                this.store = form(
                    { 
                        type : 'infusionsoft', 
                        name : '' 
                    }
                ) ;  
            }
        },
		created(){
            this.init()
        }
	}
</script>