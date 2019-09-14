<template>
    <div>
        <a-form :layout="'vertical'">
            <a-form-item :label="$lang('mobile option trello priorty name')">
                <a-input
                    v-decorator="[
                        'name',
                        {rules: [{ required: true, message: 'Please input name!' }]} ]"
                    v-model="priorty.name" :placeholder="$lang('mobile option trello priorty name')" /> 
            </a-form-item>
            <a-form-item :label="$lang('mobile option trello priorty label')">
                <a-select v-model="priorty.idLabels">
                    <a-select-option v-for="item in priorityFilter" :key="item.id" :value="item.id">
                        {{item.name}}
                    </a-select-option>
                </a-select> 
            </a-form-item>
            <a-form-item :label="$lang('mobile option trello priorty date')">
                <a-input
                    v-decorator="[
                        'cardId',
                        {rules: [{ required: true, message: 'Please input Date !' }]} ]"
                    v-model="priorty.date" :placeholder="$lang('mobile option trello priorty date')" /> 
            </a-form-item>
        </a-form>
        <a-button :loading="updatePriorityBtnloading" :disabled="!updatePriortyBtn" @click="updatePriorty" type="primary" block>{{$lang('mobile option trello priorty valider')}}</a-button>
        <a-table 
        :columns="fieldsPriorty"
        :dataSource="mobile.priority"
        :loading="loadingPriorty"
        rowKey="id">
            <template slot="name" slot-scope="name , record">
                <span>{{record.value.name}}</span>
            </template>
            <template slot="date" slot-scope="date , record">
                <span>{{$lang('mobile option trello priorty date add')}} {{record.value.date}} j </span>
            </template>
            <template slot="action" slot-scope="action , record">
                <a-button type="danger" @click="deletePriority(record)" >{{$lang('mobile option trello priorty delete')}}</a-button>
            </template>
        </a-table>
    </div>
</template>
<script>
    
    let fieldsPriorty =  [
        {
            title: 'TITLE',
            dataIndex: 'name',
            width: 150,
            scopedSlots: { customRender: 'name' },
        },
        {
            title: 'DATE',
            dataIndex: 'date',
            width: 150,
            scopedSlots: { customRender: 'date' },
        },
        {
            title: 'Action',
            dataIndex: 'action',
            width: 150,
            scopedSlots: { customRender: 'action' },
        }
    ];

	export default {
		props : ['data'], 
		data(){
            return {
                assinged : { name : '' , idList : '' , idMembers : '' } , 
                loadingPriorty : true ,
                updatePriortyBtn : false ,
                updatePriorityBtnloading : false , 
            }
        },
        methods : {
            
            async initPriority(){
                await mobile.findPriorty( this.data.id ) ; 
                this.updatePriortyBtn = true ;
                this.loadingPriorty = false ;
            },

            async initTrelloFromPriority(){
                await trello.allLabel( this.data.trello ) ;
            },

            async updatePriorty(){
                if ( this.priorty.name , this.priorty.date , this.priorty.idLabels ) {
                    this.updatePriorityBtnloading = true ; 
                    let [ err , p ] = await mobile.priorty( this.data.id , { name : this.priorty.name , date : this.priorty.date , idLabels : this.priorty.idLabels }) ; 
                    this.loadingPriorty = true ;
                    if( !err ) this.initPriority() ; 
                    this.priorty.name = '' ;
                    this.priorty.date = '' ;
                    this.priorty.idLabels = '' ;
                    this.updatePriorityBtnloading = false ; 
                }
            },

            async deletePriority( e ){
                let [ err , p ] = await mobile.depriorty( e.id ) ; 
                this.loadingPriorty = true ;
                if( !err ) this.initPriority() ; 
            },

        },
		created(){

		}
	}
</script>