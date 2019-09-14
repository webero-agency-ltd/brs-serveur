<template>
    <a-tabs defaultActiveKey="1">
        <a-tab-pane v-show="showed" key="1">
            <span slot="tab">
                {{this.$lang('mobile option trello board')}}
            </span>
            <option-boards v-if="trello" :trello="trello" :data="{trello:data.trello,app:data.id}" ></option-boards>
        </a-tab-pane>
        <a-tab-pane v-show="showed" :disabled="disabled" key="2">
            <span slot="tab">
                {{this.$lang('mobile option trello assinged')}}
            </span>
            <option-assigned></option-assigned>
        </a-tab-pane>
        <a-tab-pane v-show="showed" :disabled="disabled" key="3">
            <span slot="tab">
                {{this.$lang('mobile option trello priorty')}}
            </span>
            <option-label></option-label>
        </a-tab-pane>
    </a-tabs>
</template>
<script>
	 
    //tableaux de selection des boards 
    let fields =  [
        {
            title: 'ID',
            dataIndex: 'checkbox',
            width: 30,
            scopedSlots: { customRender: 'checkbox' },
        },
        {
            title: 'TITLE',
            dataIndex: 'name',
            width: 150,
            scopedSlots: { customRender: 'name' },
        }
    ]; 

	export default {
		props : ['data'], 
		data(){
            return {
                trello : null ,  
                disabled : false , 
                showed : false , 
                fields ,
                //option de la selection de board  
                board : null , 
                //loader de chaque button 
                updateBoardBtnloading : false , 
            }
        },

        computed : {
            assingedMembre : function (argument) {
                let preformate = [ ...this.trello.teams , { id : 'default' , name : this.$lang('mobile option trello assinged default')} ] ; 
                let $teams = preformate.filter( (a) => 
                    ! this.mobile.assigned.trello.find( e => e.value.idMembers == a.id ) 
                    //&& this.native_id !== a.id 
                )
                return $teams ; 
            },
            priorityFilter : function(){
                let $labels = this.trello.labels.filter( (a) =>
                    ! this.mobile.priority.find( e => e.value.idLabels == a.id ) 
                )
                return $labels
            }
        },

        methods : {
            async initTrelloInfo(){
                let a = new this.application() ;
                let [ err , { data } ] = await a.find( this.data.trello ) ; 
                if( err )
                    return !0 ; //@todo : afficher une page d'erreur en todo
                this.trello = data ; 
                if ( !this.trello.url ) 
                    this.disabled = true ;  
                else{
                    this.board = this.trello.url ;
                } 
                this.showed = true ;
                return true ;
            },

            async init(){
                await this.initTrelloInfo() ; 
                this.updateBoardBtn = true; 
            }

        },
		created(){
            this.init() ; 
			/*
                this.on('ApplicationCreate',async () => {
                    await application.addApplication( { name :this.name , type : this.type } )
                    this.emit('closemodale') ; 
                });
            */
            this.on('onboardupdate',async () => {
                this.disabled = false;
            });
		}
	}
</script>