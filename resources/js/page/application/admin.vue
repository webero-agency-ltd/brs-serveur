<template>
	<a-layout style="width: 100% ; height: 100% ; ">    
        <admin-menu></admin-menu>
        <a-layout-content :style="{ background: '#fff', padding: '0px', margin: 0, minHeight: '280px' }" style="width: 100% ; height: 100% ; overflow: auto; display: flex;">
            <admin-sidebar></admin-sidebar>
            <vue-page-transition name="fade-in-right" style="flex: 1;">
                <router-view style="width: 100% ; height: 100% ; overflow: auto;"></router-view> 
            </vue-page-transition>
        </a-layout-content>
        <modal></modal>
    </a-layout> 
</template>
<script>

    import router from '../router/index';
    export default {
        router : router('Admin') , 
        data(){ 
            return {
                page : window.location.pathname ,
            }
        },
        computed : {},
        methods : {},
        mounted(){},
    }

</script>
<style>
    
</style>