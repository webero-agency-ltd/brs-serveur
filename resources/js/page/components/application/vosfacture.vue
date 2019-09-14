<template>
    <a-spin :spinning="spinning">
        <b-form 
            v-if="editable"
            :event="'ApplicationCreateVosFacture'" 
            :model="'application'"
            :layout="'vertical'"
            :label="'admin create application'"
            :store="store"
            :id="application.id?application.id:null"
            :title="$lang('vosfacture edit title')"
            @ok="ok">
            <b-form-item :champ="'name'">
                <a-input 
                    v-model="form.name"
                    :placeholder="$lang('admin application vosfactures name')" /> 
            </b-form-item>
            <b-form-item :champ="'auth'">
                <a-radio-group
                    v-model="form.auth"
                    style="width: 100%;">
                    <a-radio-button style="width: 50%;" value="accessToken">
                        Access Token
                    </a-radio-button>
                    <a-radio-button style="width: 50%;" value="auth">
                        Password
                    </a-radio-button>
                </a-radio-group>
            </b-form-item>
            <b-form-item v-if="form.auth=='auth'" :champ="'login'">
                <a-input 
                    v-model="form.login" 
                    :placeholder="$lang('admin application vosfactures login')" /> 
            </b-form-item>
            <b-form-item v-if="form.auth=='auth'" :champ="'password'">
                <a-input
                    v-model="form.password" 
                    :placeholder="$lang('admin application vosfactures password')" /> 
            </b-form-item>
            <b-form-item v-if="form.auth=='accessToken'" :champ="'accessToken'">
                <a-input 
                    v-model="form.accessToken"
                    :placeholder="$lang('admin application vosfactures accessToken')" /> 
            </b-form-item>
            <b-form-item v-if="form.auth=='accessToken'" :champ="'url'">
                <a-input 
                    v-model="form.url"
                    :placeholder="$lang('admin application vosfactures url')" /> 
            </b-form-item>
            <a-button 
                @click="emit('ApplicationCreateVosFacture')">
                {{$lang('application vosfactures submit')}}
            </a-button>
        </b-form>
        <div v-if="read">
            <h2>{{vosfacture.name}}</h2>
            <p><a target="_blank" :href="vosfacture.url">{{vosfacture.url}}</a></p>
            <a-button 
                @click="edite">
                {{$lang('application vosfactures btnedit')}}
            </a-button>
        </div>
    </a-spin>
</template>
<script>

    import form from '../../store/form' ; 

	export default {
		props : [], 
		data(){
            return {
                store : null ,
                temp : {} ,
                vosfacture : {} ,
                spinning : true ,
                editable : false , 
                read : false, 
            }
        },
        computed: {
            form : function (argument) {
                if( this.store )
                return this.store.state.form
            },
            application : function (argument) {
                if( this.vosfacture )
                    return this.vosfacture ;
                return {}
            }
        },
        methods : {
            //la création est OK, on fait cette actions 
            ok( { data } ){
                this.vosfacture = data ; 
                this.editable = false ; 
                this.read = true ; 
            },
            edite(){
                this.editable = true ; 
                this.read = false ; 
            },
            async init(){
                this.store = form(
                    { 
                        login :'ahheldino@gmail.com' , 
                        password :'emirah21152013' , 
                        type : 'vosfacture', 
                        auth : 'auth', 
                        accessToken : 'HECGcWtEGbX8UNHrXNZ/ahheldino' , 
                        name : 'name test application' ,
                        url : 'https://ahheldino.vosfactures.fr' , 
                    }
                ); 
                //récupération d'application s'il existe 
                let a = new this.$model.application() ; 
                let [ err , vosfacture ] = await a.show('index', { type : 'vosfacture' }) ;
                if( vosfacture && vosfacture.id ) this.vosfacture = vosfacture ;
                this.spinning = false ; 
                if( this.vosfacture && !this.vosfacture.id ){
                    this.editable = true ; 
                    //s'il y a des valeur / defaut, on fait la récupération ICI
                }else{
                    this.read = true ;
                }
            }
        },
		created(){
            this.init()
        }
	}
</script>