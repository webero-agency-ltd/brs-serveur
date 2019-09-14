<template>
    <div :style="{ marginLeft: 'auto', marginRight: 'auto', background: '#fff', padding: '24px', minHeight: '380px' , maxWidth : '992px' }" style="overflow-x: hidden; overflow-y: auto; ">
        <a-row :gutter="12">
            <a-col>
                <infusionsoft-contact></infusionsoft-contact>
            </a-col>
            <a-col>
                <infusionsoft-contact></infusionsoft-contact>
            </a-col>
            <a-col>
                <infusionsoft-contact></infusionsoft-contact>
            </a-col>
        </a-row>
    </div>
</template>
<script>

    export default {
        props : [ ], 
        data(){
            return {
                
            }
        },
        computed: {
        
        },
        methods : { 

        },
        created(){ 

        }
    }
</script>