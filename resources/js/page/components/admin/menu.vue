<template>
	<a-layout-header class="header">
        <div class="logo" >
            <a href="/">
                <a-avatar  src="/img/logo.png" /> 
            </a>
        </div>
    </a-layout-header>
</template>

<script>

	export default {
		props : [], 
		data(){
            return {

            }
        },

        methods : {

        },

        watch:{

		}, 
		 
		created(){
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