<template>
    <button
    		class="btn btn-default"
    		v-bind:class="{'btn-success':voted}"
    		v-text="text"
    		v-on:click.prevent="vote">
    </button>
</template>
<script>
	export default {
		name: 'uservotebutton',
		props: ['answer','count'],
	    mounted(){
	    	axios.post('/api/answer/'+this.answer+'/vote/users').then(res => {
	    		this.voted = res.data.voted

	    	})
	    },
	    data(){
	    	return {
	    		voted: false
	    	}
	    },
	    methods: {
	    	vote(){
	    		axios.post('/api/answer/vote',{'answer':this.answer}).then(res => {
		    		this.voted = res.data.voted
		    		res.data.voted ? this.count++ : this.count--
		    		console.log(res.data)
		    	})
	    	}
	    },
	    computed: {
	    	text() {
	    		return this.count
	    	}
	    }
	}
</script>