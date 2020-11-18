<template>
    <div class="card mt-5 p-5">
        <div v-if="auth" class="form-inline my-4 w-full">
            <input v-model="newComment" type="text" class="form-control form-control-sm w-80">
            <button @click="addComment" class="btn btn-sm btn-primary">
                Add comment
            </button>
        </div>
        <comment v-for="comment in comments.data" :key="comment.id" :comment="comment" :video="video"></comment>
        <div class="text-center">
            <button v-if="comments.next_page_url" @click="fetchComments" class="btn btn-success">
                Load more
            </button>
            <span v-else>No more comments to show :)</span>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Comment from './Comment'
export default {
    props: ['video'],
    components: {
        Avatar, Comment
    },
    mounted() {
        this.fetchComments()
    },
    computed: {
       auth() {
           return AuthUser
        }
    },
    data: () => ({
       comments: {
           data: []
       },
        newComment: ''
    }),

    methods: {
        fetchComments() {
            const url = this.comments.next_page_url ? this.comments.next_page_url : '/videos/'+this.video.id+'/comments'
            axios.get(url)
                .then(({data}) => {
                    this.comments = {
                        ...data,
                        data: [
                            ...this.comments.data,
                            ...data.data
                        ]
                    }
                })
        },
        addComment() {
            if(! this.newComment) return
            axios.post('/comments/'+this.video.id, {
                body: this.newComment
            }).then(({data}) => {
                this.comments = {
                    ...this.comments,
                    data: [
                        data,
                        ...this.comments.data
                    ]
                }
            })
        }
    }
}
</script>

<style scoped>
.w-full {
    width: 100% !important;
}
.w-80 {
    width: 80% !important;
}
.thumbs-up, .thumbs-down {
    width: 20px;
    height: 20px;
    cursor: pointer;
    fill: currentColor;
}
.thumbs-down-active, .thumbs-up-active {
    color: #3EA6FF
}
.thumbs-down {
    margin-left: 1rem;
}
</style>
