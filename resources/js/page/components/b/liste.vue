<template>
	<div style="width: 100% ; height: 100% ;" >
        <a-row v-infinite-scroll="handleInfiniteOnLoad" style="width: 100% ; height: 100% ; overflow: auto;" v-if="rowable" :gutter="gutter">
            <a-col style="margin-bottom: 1rem;" :span="span" v-for="item in lists" :key="item.id">
                <div v-if="loadingmore" class="message_body_loading-container">
                    <a-spin />
                </div>
                <component v-bind:is="tpl" :item="item" :dataItem="dataItem"></component>   
            </a-col>   
        </a-row>
        <a-list
            v-if="!rowable"
            style="flex: 1 ; overflow-y: auto;"
            class="demo-loadmore-list ant-row"
            v-infinite-scroll="handleInfiniteOnLoad"
            :loading="loading"
            :dataSource="(storable?listsStore:liste)"
            >
            <div v-if="loadingmore" class="message_body_loading-container">
                <a-spin />
            </div>
            <a-list-item slot="renderItem" slot-scope="item, index">
                <component v-bind:is="tpl" :item="item" :dataItem="dataItem"></component>  
            </a-list-item>
        </a-list>
    </div>
</template>
<script>
    
    import infiniteScroll from 'vue-infinite-scroll';
    import { mapGetters } from 'vuex' ; 

    export default {

        /*
         * @form : store vuex formulaire de recherche s'il existe 
         * @model : nom de modele a appel 
         * @module : si dans le modele on utilise des modules  
         * @tpl : composante item de la liste 
         * @dataItem : si on a des data a envoyer dans la listes 
         * @k : nom du key s'il existe  

         * @more : si on utilise le more ou le next   
         * @nextable : si on utilise next et prévius mais pas more   
         * @event : name de l'évenement a écouter si l'on veut intéragire avec le composante depuis l'extérn
         * @rowable : si on veut utiliser les row ou le composante liste 
         * @gutter : gutter du row 
         * @span : span du row 
         * @store : si store existe alors on affiche ces element dans le store 
         * @storable : si on veut utilisé le store 
        */
        directives: { infiniteScroll },
		props : [ 
            'form' , 
            'model' , 
            'module' , 
            'tpl' , 
            'dataItem' , 
            'k' , 
            'moreable' , 
            'event' ,
            'rowable' ,
            'gutter' ,
            'span' ,
            'morescroll' , 
            'stored' , 
            'storable' , 
            'filter' , 
        ], 
		data(){
            let kktos = {
                app : this.model ? new this.$model[this.model]() : null , 
                //loader de recherche 
                loading : false ,
                loadingmore : false ,  
                last_page_url : '' , 
                next_page_url : '' , 
                //
                page : 0 , 
                curentQuery : {} , 
            }
            if( ! this.storable )
                kktos['lists'] = [] ; 
            return kktos ; 
        },
        computed: {
            listsStore() {
                return this.stored.state.lists 
            }
        },
        methods : {

            handleInfiniteOnLoad : async function () {
                if( this.morescroll )
                    this.more() ; 
            },

            next : async function (){
                if( !this.next_page_url ) return ; 
                this.page++;
                let [ err , data ] = await this.find({page:this.page})
                if( err ) return this.$emit( 'error', err ) ; 
                this.lists = [ ...data ] ;
            },

            prev : async function (){
                if( this.page <= 1 ) return this.$emit( 'end-prev', err ) ; 
                this.page--;
                let [ err , data ] = await this.find({page:this.page})
                if( this.page <= 1 ) this.$emit( 'end-prev', err ) ; 
                if( err ) return this.$emit( 'error', err ) ; 
                this.lists = [ ...data ] ;
            },

            //reade more element 
            more : async function (){
                if( !this.next_page_url ) return ; 
                this.page++;
                let [ err , data ] = await this.find({page:this.page})
                if( err ) return this.$emit( 'error', err ) ; 
                this.lists = [ ...this.lists , ...data ] ;
            },

        	init : async function () {
                if ( this.stored ) {
                    this.store = this.stored ;
                }else{
                    this.page++;
                    let [ err , data ] = await this.find( this.filter ? this.filter : {} )
                    if( err ) return this.$emit( 'error', err ) ; 
                    this.lists = data ;
                }
            },

            search : async function ( query ) {
                this.page = 1 ;
                let [ err , data ] = await this.find( query )
                if( err ) return this.$emit( 'error', err ) ; 
                this.lists = data ;
            },

            find : async function ( query = {} ){
                this.curentQuery = Object.assign( {} , query ) ; 
                //récupération de la listes 
                let [ err , { data , last_page_url , next_page_url } ] = await this.app.get( query ) ;
                this.next_page_url = next_page_url ; 
                if( !this.next_page_url ) { 
                    this.$emit('end-next') 
                    this.$emit('end-more') 
                } ;
                return [ err , data ]
            },

            //scroll
            onScroll(){

            }

        },
		mounted(){
			this.init() ; 
            if( this.event ){
                this.on( this.event , ({ action , data }) => {
                    if( action == 'next' ) this.next( data ) ; 
                    else if( action == 'prev' ) this.prev( data ) ; 
                    else if( action == 'more' ) this.more( data ) ;
                    else if( action == 'search' ) this.search( data ) ;
                    else if( action == 'refresh' ) this.search( {} ) ;
                } , true )
            }
		}
	}
</script>
<style>

    .ant-list-split .ant-list-item {
        border : none;
    }

    .ant-list-item {
        align-items: center;
        display: flex;
        padding: 12px 0;
    }

</style>