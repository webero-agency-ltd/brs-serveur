<template>
    <a-spin :spinning="spinning">
        <h2 v-if="title">{{title}}</h2>
        <a-alert v-if="message" :message="message" :type="error?'error':'success'" showIcon />
        <a-form :layout="layout" >
            <slot></slot>
        </a-form>
    </a-spin>
</template>
<script>
    export default {
        
		props : ['layout','model','event','id','method','store','label','submit','title'], 

		data(){
            return {
                app : this.model ? new this.$model[this.model]() : null , 
                spinning : false , 
                message : null , 
                error : true , 
            }
        },

        computed: {},

        methods : {
        	messageShoed : async function ( msg ) {
                this.message = this.$lang( msg ) ; 
                setTimeout( () => {
                    this.message = null ; 
                }, 6000); 
            },
        },
		mounted(){
            this.on( this.event ,async () => {
                this.spinning = true ; 
                let err , res ;
                //let body = this.store.state.form ;
                let body = this.store.state.form ;
                if( this.submit )
                    return this.$emit( 'submit' , body )
                if( this.id )
                    [ err , res ] = await this.app[(this.method?this.method:'update')]( this.id , body )    
                else 
                    [ err , res ] = await this.app[(this.method?this.method:'store')]( body ) 
                console.log(' ----------------------- ');
                console.log( err , res ) ; 
                if( err ){
                    //ajoute automatiquement des erreus 
                    this.store.commit( 'addError' , err ) ;
                    if( err.message ){
                        this.messageShoed( err.message )
                        this.error = true ;  
                    }
                    this.spinning = false ; 
                    this.emit('resetbtnmodale') ; 
                    return this.$emit("error" , err ) 
                } 
                else {
                    if( res.message ){
                        this.messageShoed( res.message )
                        this.error = false ; 
                    }
                    this.spinning = false ; 
                    return this.$emit("ok" , res ) 
                }
            } , true );
		}
	}
</script>
<style>

    .spin-content{
        border: 1px solid #91d5ff;
        background-color: #e6f7ff;
        padding: 30px;
    }

</style>