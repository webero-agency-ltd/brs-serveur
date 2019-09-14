<template>
	<a-layout-header class="header">
        <div class="logo" >
            <a href="/">
                <a-avatar  src="/img/logo.png" /> 
            </a>
        </div>
        <a-menu :style="{ lineHeight: '64px' , float : 'right' }" v-model="current"  mode="horizontal">
            <a-menu-item v-for="menu in menus" :key="menu.name">
                <router-link :to="{name:menu.name}">
                    {{$lang(menu.text)}} 
                </router-link>
            </a-menu-item>
        </a-menu>
    </a-layout-header>
</template>

<script>
	let menus = document.menus.filter( ( e ) => {
		if( e.permition == "*" )
			return true 
		let all = e.permition.split(' ')
		for( let item of all ){
			let permission = document.permissions.find( p => p.slug.indexOf( item ) != -1 )
			if( permission )
				return true ; 
		}
		return false ; 
	})
	export default {
		props : [], 
		data(){
            return {
            	current : [ menus[0].name ] ,
            	menus ,  
            }
        },

        methods : {
            init(){
		        this.current = [ this.$route.name ]     
            }
        },

        watch:{
		    $route (to, from){
		        this.current = [ this.$route.name ]
		    }
		},  
		created(){
            this.init()
        }
	}
</script>
<style>
	.logo {
	    width: 120px;
	    height: 31px;
	    float: left;
	    margin: 0px;
	}
	
	/*@Ecrase :*/
	.ant-layout-header {
	    background: #f0f2f5;
	}
	.ant-menu-horizontal{
		background-color: #f0f2f5
	}

</style>