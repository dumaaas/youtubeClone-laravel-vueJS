<template>
    <div>
        <a @click="vote('up')">
            <i @click="vote('up')" class="far fa-thumbs-up thumbs-up" :class="{'thumbs-up-active': upvoted}"></i> {{upvotes_count}}
        </a>
        <a @click="vote('down')">
            <i @click="vote('down')" class="far fa-thumbs-down thumbs-down" :class="{'thumbs-down-active': downvoted}"></i> {{downvotes_count}}
        </a>
    </div>
</template>

<script>
import numeral from 'numeral'
export default {
    props: {
        default_votes: {
            required: true,
            default: () => []
        },
        entity_owner: {
            required: true,
            default: ''
        },
        entity_id: {
            required: true,
            default: ''
        }
    },

    data() {
        return {
            votes: this.default_votes
        }
    },

    computed: {
        upvotes() {
            return this.votes.filter(v => v.type === 'up')
        },

        downvotes() {
            return this.votes.filter(v => v.type === 'down')
        },
        upvotes_count() {
            return numeral(this.upvotes.length).format('0a')
        },
        downvotes_count() {
            return numeral(this.downvotes.length).format('0a')
        },
        upvoted() {
            if(! AuthUser) return false
            return !!this.upvotes.find(v => v.user_id === AuthUser.id)
        },
        downvoted() {
            if(! AuthUser) return false
            return !!this.downvotes.find(v => v.user_id === AuthUser.id)
        }

    },
    methods: {
        vote(type) {
            if(AuthUser && AuthUser.id === this.entity_owner) {
                return alert('You can not vote on your own video!')
            }
            if(!AuthUser) {
                return alert('Please login to vote!')
            }
            if(type==='up' && this.upvoted) return
            if(type==='down' && this.downvoted) return

            axios.post('/votes/'+this.entity_id+'/'+type)
                .then(({data}) => {
                    if(this.upvoted || this.downvoted) {
                        this.votes = this.votes.map(v => {
                            if(v.user_id === AuthUser.id) {
                                return data
                            }
                            return v
                        })
                    } else {
                        this.votes = [
                            ...this.votes,
                            data
                        ]
                    }
                })
        }
    }
}
</script>

<style>

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

