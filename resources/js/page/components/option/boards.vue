<template>
    <div>
        <a-table 
            :columns="fields"
            :dataSource="boards"
            :loading="loadingBoard"
            rowKey="id">
            <template slot="checkbox" slot-scope="checkbox , record">
                <a-radio-group v-model="board">
                    <a-radio :value="record.url"></a-radio>
                </a-radio-group>
            </template>
            <template slot="name" slot-scope="name , record">
                <a target="_blank" :href="record.url">{{record.name}}</a>
            </template>
        </a-table>
        <a-button :loading="updateBoardBtnloading" :disabled="!updateBoardBtn" @click="updateBoard" type="primary" block>{{$lang('mobile option trello board valider')}}</a-button>
    </div>
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
		props : ['data','trello'], 
		data(){
            return {
                loadingBoard : true ,
                fields ,
                //option de la selection de board  
                board : null , 
                boards : [] , 
                updateBoardBtn : false ,
                //loader de chaque button 
                updateBoardBtnloading : false , 
            }
        },

        methods : {

            async updateBoards(){
                if( this.data.app )
                    await mobile.destroyOption( this.data.app )
                console.log( this.trello.boards )
                this.updateBoardBtnloading = true ;
                let { id , url } = this.trello.boards.find( ( { url }) => {
                    return url == this.board ? true : false ;
                })
                await application.update( this.data.trello , { url }) ; 
                await option.create({ name : `application_${this.data.trello}_native` , value : id }) ; 
                this.updateBoardBtnloading = false ;
                let [ e , r ] = await application.initCard( this.data.trello )
                if( e || !r ){
                    alert('une erreur est survenue')
                    return !1 ;
                }
                let [ err , res ] = await application.update( this.data.trello , { url }) ; 
                if( !err )
                    this.emit('onboardupdate', res )
                
            },

            async updateBoard(){
                let m = new this.mobile() ; 
                if( this.data.app )
                    await m.option.destroy( this.data.app ) ; 
                this.updateBoardBtnloading = true ;
                let { id , url } = this.boards.find( ( { url }) => {
                    return url == this.board ? true : false ;
                })
                let o = new this.plugoption() ; 
                await o.create( { name : `application_${this.data.trello}_native` , value : id } ) ;
                this.updateBoardBtnloading = false ;
                let a = new this.application() ;
                let [ e , r ] = await a.initCard.find( this.data.trello ) ;
                if( e || !r ){
                    return !1 ;
                }
                let [ err , res ] = await a.update( this.data.trello , { url }) ; 
                if( !err )
                    this.emit('onboardupdate', res )
            },

            async init(){
                this.board = this.trello.url ; 
                let t = new this.plugtrello() ; 
                let [ err , { data } ] = await t.boards.find( this.trello.id ) ; 
                this.boards = data ; 
                this.loadingBoard = false;
                this.updateBoardBtn = true; 
            }

        },
		created(){
            this.init() ; 
		}
	}
</script>