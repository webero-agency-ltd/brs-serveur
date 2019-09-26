<template>
	<div style="overflow-x: hidden; overflow-y: auto; padding: 32px">
        <a-row :gutter="12">
            <a-col>
                <h1>Home page</h1>
            </a-col>
        </a-row>
    </div>
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