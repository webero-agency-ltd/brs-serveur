<template>
    <div>
        <a-form :layout="'vertical'">
            <a-form-item :label="$lang('mobile option trello assinged name')">
                <a-input
                    v-decorator="[
                        'name',
                        {rules: [{ required: true, message: 'Please input name!' }]} ]"
                    v-model="assinged.name" :placeholder="$lang('mobile option trello assinged name')" /> 
            </a-form-item>
            <a-form-item :label="$lang('mobile option trello assinged list')">
                <a-select v-model="assinged.idList">
                    <a-select-option v-for="item in trello.lists" :key="item.id" :value="item.id">
                        {{item.name}}
                    </a-select-option>
                </a-select> 
            </a-form-item>
            <a-form-item :label="$lang('mobile option trello assinged membre')">
                <a-select v-model="assinged.idMembers">
                    <a-select-option v-for="item in assingedMembre" :key="item.id" :value="item.id">
                        {{item.name}}
                    </a-select-option>
                </a-select> 
            </a-form-item>
        </a-form>
        <a-button icon="plus" :loading="updateAssingedBtnloading" :disabled="!updateAssinedBtn" @click="updateAssigned" type="primary" block>{{$lang('mobile option trello assinged valider')}}</a-button>
        <a-table 
        :columns="fieldsAssigned"
        :dataSource="mobile.assigned.trello"
        :loading="loadingAssigned"
        rowKey="id">
            <template slot="name" slot-scope="name , record">
                <span>{{record.value.name}}</span>
            </template>
            <template slot="action" slot-scope="action , record">
                <a-button type="danger"  @click="deleteAssigned(record)" >{{$lang('mobile option trello assinged delete')}}</a-button>
            </template>
        </a-table>
    </div>
</template>
<script>
    
    let fieldsAssigned =  [
        {
            title: 'TITLE',
            dataIndex: 'name',
            width: 150,
            scopedSlots: { customRender: 'name' },
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
                updateAssinedBtn : false ,
                loadingAssigned : true ,
                priorty : { name : '' , date : '' , idLabels : '' } , 
                updateAssingedBtnloading : false ,                 
            }
        },
        methods : {

            async loadAssigned () {
                return await mobile.findAssigned( this.data.id , 'trello' ) ; 
            },
            
            async init(){
            
            },

            async updateAssigned(){
                if ( this.assinged.name , this.assinged.idList , this.assinged.idMembers ) {
                    let [ err , res ] = await mobile.assigned( this.data.id , { name : this.assinged.name , idList : this.assinged.idList , idMembers : this.assinged.idMembers }) ; 
                    this.loadingAssigned = true ;
                    this.assinged.name = '' ;
                    this.assinged.idList = '' ;
                    this.assinged.idMembers = '' ;
                    if( !err ) this.initAssigned() ; 
                    else this.loadingAssigned = false ;
                }
            },

            async initAssigned(){
                this.updateAssingedBtnloading = true ; 
                await this.loadAssigned() ;
                let [err , info ] = await team.info( this.data.trello ) ;
                this.native_id = info.native_id ; 
                this.updateAssinedBtn = true ;
                this.loadingAssigned = false ;
                this.updateAssingedBtnloading = false ; 
            },

            async initTrelloFromAssinged(){
                await trello.allList( this.data.trello ) ; 
                await trello.allMembres( this.data.trello ) ;
            },

            async deleteAssigned( item ){
                let [ err , res ] = await mobile.deassigned( item.id ) ; 
                this.loadingAssigned = true ;
                if( !err ) this.initAssigned() ; 
                else this.loadingAssigned = false ;
            },

        },
		created(){

		}
	}
</script>