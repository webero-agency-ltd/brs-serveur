<template>
	<a-menu
		v-model="current"
	    style="overflow-y:auto; overflow-x: hidden ; width: 256px"
	    mode="inline">
	    <component v-for="menu in menus" :key="menu.name" v-bind:is="menu.childs.length>0?'a-sub-menu':'a-menu-item'">
	    	<router-link v-if="!menu.childs.length" :to="{name:menu.name}">
                {{$lang(menu.text)}} 
            </router-link>
            <span slot="title" v-if="menu.childs.length" ><span>{{$lang(menu.text)}}</span></span>
            <a-menu-item v-for="child in menu.childs" :key="child.name" >
				<router-link :to="{name:child.name}">
	                {{$lang(child.text)}} 
	            </router-link>
            </a-menu-item>
	    </component>
	</a-menu>
</template>

<script>

	let menus = document.menus ;

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