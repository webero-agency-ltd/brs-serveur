<template>
    <div :style="{ marginLeft: 'auto', marginRight: 'auto', background: '#fff', padding: '24px', minHeight: '380px' , maxWidth : '992px' }">
        <div v-if="notify" style="position: fixed ; z-index: 1000; width: 50%; max-width: 500px ; left: 50% ; transform: translateX(-50%);">
            <a-alert
                :message="notifyMessage"
                :type="notifyType">
                <div slot="description">
                    <b-liste  
                        :tpl="'application-reloadcontact'"        
                        :rowable="false"        
                        :gutter="16"        
                        :event="'notification-index-liste-event'"        
                        :span="8"
                        :storable="true"
                        :stored="fetchContact">      
                    </b-liste>
                </div>
            </a-alert>
        </div>
        <div style="display: flex;">
            <h1>{{$lang('operateur index title')}}</h1>
            <h3 style="flex: 1;"><a @click.stop.prevent="createMobile" style="float: right; line-height: 2rem;"><a-icon type="mobile" />{{$lang('operateur index mobile')}}</a></h3>
        </div>
        <a-divider dashed />
        <b-liste  
            :model="'mobile'" 
            :tpl="'mobile-item'"        
            :rowable="true"        
            :gutter="16"        
            :event="'mobile-index-liste-event'"        
            :span="8">        
        </b-liste>
        <a-divider />
        <b-liste  
            :model="'application'" 
            :tpl="'application-item'"        
            :rowable="true"        
            :gutter="16"        
            :event="'application-index-liste-event'"  
            :filter="{all:true}"      
            :span="8">        
        </b-liste>
        <div style="margin-top: 1.5rem;">
            <!--<a-button type="primary" icon="plus-circle" @click="more" >{{this.$lang('operateur create more')}}</a-button>-->
            <a-button type="primary" icon="plus-circle" @click="newapplication" block >{{this.$lang('operateur create button')}}</a-button>
        </div>
    </div>
</template>
<script>
    
    //importation des stores de l'élement 
    import fetchContact from '../../store/fetchContact' ; 

    export default {
        props : [ ], 
        data(){
            return {
                //application : application.state , 
                //mobile : mobile.state , 
                //notification 
                notify : false ,
                notifyType : 'info' , 
                notifyMessage : '' , 
                fetchContact
            }
        },
        computed: {
        
        },
        methods : {

            createMobile(){
                this.emit('modal',{
                    title : this.$lang('operateur create mobile title') , 
                    component : 'mobile-create' , 
                    handleOk : 'MobileCreate'
                })
            },

            newapplication() { 
                this.emit('modal',{
                    title : this.$lang('operateur create application title') , 
                    component : 'application-create' , 
                    handleOk : 'ApplicationCreate'
                })
            },

            //récupération de l'intégralité des contacts 
            async allContact( ids ){
                let a = new this.application() ; 
                let search = [] ; 
                let [ err , { data } ] = await a.get( { ids : ids.join('_') } ) ;
                if( !data || !data.length )
                    return !0 ; 
                for ( let item of ids ){
                    let appItem = data.find( e => e.application.id == item ) 
                    if( appItem )
                        search.push({ title : this.$lang('operateur application charge contact') +' '+ appItem.application.name , progress : 0 , start : false })
                }
                this.notify = true ; 
                let index = 0 ;
                await fetchContact.commit( 'addSyncContact', search )
                let i = new this.infusionsoft() ; 
                for ( let item of ids ){
                    fetchContact.commit( 'startSyncContact', index );
                    await i.fetchContact( item , ( res ) => {
                        console.log( res )
                        if( res && res.value && res.value.percenty ){
                            let progress = parseFloat( res.value.percenty ) ; 
                            console.log( progress )
                            fetchContact.commit( 'progressSyncContact', { index , progress  } )
                        }
                    })
                    fetchContact.commit( 'stopSyncContact', index )
                    index++ ; 
                }
                this.notify = false ; 
                search = [] ;
                fetchContact.commit( 'addSyncContact', search )
            },

            async init(){
                //récupération de tout vos application IFS qui n'on pas de conctact, ou 
                //tout simplement qui on de nouvelle contact 
                let i = new this.infusionsoft() ; 
                let [ err , {data} ] = await i.readycontact.get() ;
                //initialisation de tout les applications Ifusionsoft qui n'on pas de contact 
                this.allContact( data ) ;
            },

            ////////////////////////////////////////
            more(){
                this.emit('application-index-liste-event',{ action : 'more' , data : 'sdsds'})
            },

        },
        mounted(){
            
            this.on('MobileCreateCloseModale',async () => {
                this.emit('mobile-index-liste-event',{ action : 'refresh' })
            })

            this.on('ApplicationCreateCloseModale',async () => {
                this.emit('mobile-index-liste-event',{ action : 'refresh' })
                this.emit('application-index-liste-event',{ action : 'refresh' })
            })

            this.init()
        
        }
    }
</script>

<style>
    .homepage{
        position: fixed;
        top: 0;left: 0;right: 0;bottom: 0;
        z-index: 1025;
        background-color: #FFF ;
        padding-top: 3rem;
    }

    .gryforover img{
        filter: grayscale(100%) ; 
    }

    .gryforover:hover img {
        filter: grayscale(0%) ; 
    }

    .ant-popover-inner-content {
        padding: 0px 16px;
        color: rgba(0, 0, 0, 0.65);
    }

</style>