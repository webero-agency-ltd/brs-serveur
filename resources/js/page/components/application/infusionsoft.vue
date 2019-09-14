<template>
    <a-spin :spinning="spinning">
        <b-form 
            v-if="editable"
            :event="'ApplicationCreateInfusionsoft'" 
            :model="'application'"
            :layout="'vertical'"
            :label="'admin create application'"
            :store="store"
            :title="$lang('infusionsoft edit title')"
            @ok="ok">
            <b-form-item :champ="'name'">
                <a-input 
                    v-model="form.name"
                    :placeholder="$lang('admin application infusionsoft name')" /> 
            </b-form-item>
            <a-button 
                @click="emit('ApplicationCreateInfusionsoft')">
                {{$lang('application infusionsoft submit')}}
            </a-button>
        </b-form>
        <div v-if="read">
            <h2>{{ifs.name}}</h2>
            <p><a target="_blank" :href="ifs.url">{{ifs.url}}</a></p>
            <div>
                <span>
                    <div v-if="contactable" style="position: relative; width: 34px; height: 34px ; display: inline-block; vertical-align: middle;">
                        <a-spin style="position: absolute; top: -2px ; left:  -2px;">
                            <a-icon slot="indicator" type="loading" style="font-size: 32px" spin />
                        </a-spin>
                        <a-progress style="position: absolute; " :width="28" type="circle" :percent="progress" />
                    </div>
                    <a-icon v-if="!contactable" type="home" />
                    <span v-if="!contactable">{{readycontact}}</span>
                    <span>contacts</span>
                </span>
            </div>
            <a-button 
                @click="edite">
                {{$lang('application infusionsoft btnedit')}}
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
                ifs : {} ,
                spinning : true ,
                read : false, 
                editable : false , 
                store : null ,
                i : null ,
                progress : 0,  
                contactable : false , 
                readycontact : 0 , 
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
                return {}
            }
        },
        methods : {
            //la création est OK, on fait cette actions 
            ok( res ){
                this.vosfacture = res.data ; 
                let win = window.open( res.redirect , '_blank');
                return win.focus();
            },
            edite(){
                this.editable = true ; 
                this.read = false ; 
            },

            //récupération de l'intégralité des contacts 
            async allContact(){
                let index = 0 ;
                let i = new this.$model.infusionsoft() ; 
                this.contactable = true ; 
                await i.fetchContact( ( res ) => {
                    console.log( res )
                    if( res && res.value && res.value.percenty ){
                        this.progress = parseFloat( res.value.percenty ) ;
                    }
                })
                this.contactable = false ; 
                this.initContact() ; 
            },

            async initContact(){
                //récupération des informations des contacts
                this.i = new this.$model.infusionsoft() ; 
                let [ err , data ] = await this.i.readycontact.get() ;
                //initialisation de tout les applications Ifusionsoft qui n'on pas de contact 
                if( data && data.ready === false )
                    this.allContact() ;
                else{
                    //la tout est ok on affiche juste de résultat
                    console.log( data )
                    this.readycontact = data.contact ; 
                }
            },

            async init(){
                //s'il y a des valeur / defaut, on fait la récupération ICI
                this.store = form(
                    { 
                        type : 'infusionsoft', 
                        name : '' 
                    }
                ) ;
                //récupération d'application s'il existe 
                let a = new this.$model.application() ; 
                let [ err , ifs ] = await a.show('index', { type : 'infusionsoft' }) ;
                if( ifs && ifs.id ) this.ifs = ifs ;
                this.spinning = false ; 
                if( this.ifs && !this.ifs.id ){
                    this.editable = true ; 
                    //s'il y a des valeur / defaut, on fait la récupération ICI
                }else{
                    this.read = true ;
                    this.initContact() ; 
                }
            }
        },
		created(){
            this.init()
        }
	}
</script>