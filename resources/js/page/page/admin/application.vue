<template>
    <div class="application-item" :style="{ marginLeft: 'auto', marginRight: 'auto', background: '#fff', padding: '24px', minHeight: '380px' , maxWidth : '992px' }" style="overflow-x: hidden; overflow-y: auto; " >
        <a-row :gutter="12">
            <a-col>
                <a-comment>
                    <a-avatar
                        :size="240"
                        src="./img/vosfactures.png"
                        alt="Han Solo"
                        slot="avatar"
                    />
                    <vosfacture slot="content"></vosfacture>
                </a-comment>
                <a-divider/>
                <a-comment>
                    <a-avatar
                        :size="240"
                        src="./img/ifsblue.jpg"
                        alt="Han Solo"
                        slot="avatar"
                    />
                    <infusionsoft slot="content"></infusionsoft>
                </a-comment>
            </a-col>
        </a-row>
    </div>
</template>
<script>

    export default {
        props : [ ], 
        data(){
            return {
                vosfacture : null , 
            }
        },
        computed: {
            
        },
        methods : {
            async init(){
                 
            }
        },
        created(){ 
            this.init() ; 
        }
    }
</script>

<style>
    .application-item .ant-avatar > img {
        width: 100% ; 
        height: 100% ; 
    }
</style>