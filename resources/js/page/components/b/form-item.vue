<template>
	<a-form-item 
        has-feedback
        :validate-status="store.state.error[champ]?'error':''" 
        :help="store.state.error[champ]?store.state.error[champ]:''"
        :label="$lang( this.$parent.$parent.$parent.label + ' ' + this.champ )">
        <slot></slot>
    </a-form-item>
</template>
<script>
    export default {
		props : [ 'champ' ], 
		data(){
            return {
                store : this.$parent.$parent.$parent.store , 
            }
        },
        computed: {
        },
        methods : {
        },
		mounted(){
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