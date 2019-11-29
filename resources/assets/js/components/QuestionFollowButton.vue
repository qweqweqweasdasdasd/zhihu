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
		name: 'questionfollowbutton',
		props: ['question'],
	    mounted(){
	    	axios.post('/api/question/follower',{'question':this.question}).then(res => {
	    		this.followed = res.data.followed
	    		console.log(res.data)
	    	})
	    },
	    data(){
	    	return {
	    		followed: false
	    	}
	    },
	    methods: {
	    	follow(){
	    		axios.post('/api/question/follow',{'question':this.question}).then(res => {
		    		this.followed = res.data.followed
		    		console.log(res.data)
		    	})
	    	}
	    },
	    computed: {
	    	text() {
	    		return this.followed ? '已关注' : '未关注'
	    	}
	    }
	}
</script>