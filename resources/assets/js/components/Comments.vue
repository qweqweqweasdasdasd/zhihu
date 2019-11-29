<template>
<div>
    <button
    		class="btn btn-success float-right"
    		@click.prevent="showCommentsFrom"
    		v-text="showtext"
    		>
    </button>
	<div class="modal fade" :id=dialog tabindex="-1" role="dia1og">
		<div Class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 Class="modal-title">
						评论列表
					</h4>
					<button type="button" class="close" data-dismiss= "modal" aria-hidden="true" >&times;</button>
				</div>
				<div class= "modal-body">
					<div v-if="comments.length > 0">
						<div class="media" v-for="comment in comments">
						  <div class="media-left">
						    <a href="#">
						      <img class="media-object" width="48px;" :src="comment.user.avatar" alt="comment.user.name">
						    </a>
						  </div>
						  <div class="media-body">
						    <h4 class="media-heading">{{comment.user.name}}</h4>
						    {{ comment.body }}
						  </div>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<input type="text" class="form-control" name="" v-model="body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" @click="store">评论</button>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
	export default {
		name: 'comments',
		props: ['type','model','count'],
		data(){
			return {
				body: '',
				comments: []
			}
		},
		computed: {
			dialog() {
				return 'comment-dialog-' + this.type + '-' + this.model
			},
			dialogId() {
				return '#' + this.dialog
			},
			showtext() {
				return this.count + '评论'
			}
		},
		methods: {
			store() {
				axios.post('/api/comment/store',{'type':this.type,'model':this.model,'body':this.body}).then(res => {
					let comment = {
						user: {
							name:Zhihu.name,
							avatar:Zhihu.avatar
						},
						body: res.data.body
					}

					this.comments.push(comment)
					this.body = ''
					this.count ++
		    	})
			},
			showCommentsFrom() {
				//alert(this.dialogId)
				this.getComments()
				$(this.dialogId).modal('show')
			},
			getComments() {
				axios.get('/api/' + this.type + '/' + this.model + '/comments').then(res => {
					this.comments = res.data
					console.log(this.comments);
				})
			}
		}
	}
</script>

<style lang="css" scoped>
	.float-right{
		float: right;
	}
</style>