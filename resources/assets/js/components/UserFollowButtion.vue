<template>
    <button
    		class="btn btn-default"
    		v-bind:class="{'btn-success':followed}"
    		v-text="text"
    		v-on:click="follow">
    </button>
</template>
<script>
	export default {
		props: ['user'],
	    mounted(){
	    	axios.get('/api/user/followers/' + this.user).then(res => {
	    		this.followed = res.data.followed
	    	})
	    },
	    data(){
	    	return {
	    		followed: false
	    	}
	    },
	    methods: {
	    	follow(){
	    		axios.post('/api/user/follow',{'user':this.user}).then(res => {
		    		this.followed = res.data.followed
		    		console.log(res.data)
		    	})
	    	}
	    },
	    computed: {
	    	text() {
	    		return this.followed ? '已关注' : '关注他'
	    	}
	    }
	}
</script>