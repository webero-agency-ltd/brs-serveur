<template>
    <a-card>
        <template class="ant-card-actions" slot="actions">
            <a-popover v-if="item.trello&&item.trello.id" placement="bottom">
                <template slot="content">
                    <p>{{item.trello.name}}</p>
                </template>
                <a-avatar class="gryforover" shape="square" :size="16" src="/img/trello/favicon-32x32.png" @click.stop.prevent="trello(item.id , item.trello.id)" type="dashboard" />
            </a-popover>
            <a-popover v-if="item.infusionsoft&&item.infusionsoft.id" placement="bottom">
                <template slot="content">
                    <p>{{item.infusionsoft.name}}</p>
                </template>
                <a-avatar class="gryforover" shape="square" :size="16" src="/img/infusionsoft/favicon-32x32.png" @click.stop.prevent="infusionsoft(item.id , item.infusionsoft.id)" type="user" />
            </a-popover>
            <a-icon theme="twoTone" twoToneColor="#ff4c50" @click="destroyMobile(item.id)" type="delete" />
        </template>
        <a-card-meta
            :description="item.user_role">
            <span slot="title">
                <a-avatar src="/img/microphone.active.svg" /> 
                <a style="color: inherit;" :href="'/mobile/'+item.id">
                    <span >{{item.name}}</span>
                </a>
            </span>
        </a-card-meta>
    </a-card>
</template>
<script>

	export default {

		props : ['item'], 

		data(){
            return {
            }
        },
        methods : {

            async infusionsoft( mobile , page ){
                this.emit('modal',{
                    title : this.$lang('operateur option mobile infusionsoft title') , 
                    component : 'option-ifs' , 
                    data : { id : mobile , infusionsoft : page } , 
                    footer : true,
                })
            }, 

            async destroyMobile( page ){
                this.emit('modal',{
                    title : this.$lang('operateur delete mobile title') , 
                    component : 'mobile-delete' , 
                    data : { id : page } , 
                    handleOk : 'MobileDestroy'
                })
            },

            async trello( mobile , page ){
                this.emit('modal',{
                    title : this.$lang('operateur option mobile trello title') , 
                    component : 'option-trello' , 
                    data : { trello : page , id : mobile } , 
                    footer : true,
                })
            },
            
        },
		created(){

		}
	}
</script>