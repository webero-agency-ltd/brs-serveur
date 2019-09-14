<template>

    <a-spin :spinning="!ready" tip="Loading...">
        <a-alert
            :description="$lang('operateur delete mobile scription') "
            type="error"
            showIcon>
            <div slot="message" v-if="name">
                {{$lang('operateur delete mobile alert')}} <strong>{{name}}</strong>
            </div>
        </a-alert>
    </a-spin>
    
</template>
<script>

	export default {
		props : ['data'], 
		data(){
            return {
                name : '',
                ready : false ,
            }
        },
        methods : {

            async init(){
                let m = new this.mobile() ; 
                let [ err , { data } ] = await m.find( this.data.id ) ; 
                if( data ){
                    this.name = data.name ; 
                    this.ready = true ; 
                }
            }
        },  
		created(){
            this.init()
			this.on('MobileDestroy',async () => {
                let m = new this.mobile() ; 
				let [ err , destroy ] = await m.destroy( this.data.id ) ; 
                this.emit('MobileCreateCloseModale')
                this.emit('closemodale') ; 
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