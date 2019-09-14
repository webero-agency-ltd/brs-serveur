<template>
    <a-list-item-meta style="width: 100%;">
        <span slot="title">
            <span style="line-height: 36px; font-size: 1.1rem;">
                {{item.title}} 
                <a-spin v-if="item.start" >
                    <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />
                </a-spin>
            </span>
        </span>
        <div slot="avatar"><a-progress :width="40" type="circle" :percent="item.progress" /></div>
    </a-list-item-meta>
</template>
<script>

	export default {

		props : ['item'], 

		data(){
            return {
            }
        },
        methods : {
            
        },
		created(){

		}
	}
</script>