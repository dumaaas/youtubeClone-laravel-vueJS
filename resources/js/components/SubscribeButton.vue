<template>
    <div>
        <button @click="toggleSubscription" class="btn btn-danger">
            {{ owner ? '' : subscribed ? 'Unsubscribe' : 'Subscribe'}} {{count}} {{owner ? 'Subscribers' : ''}}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        channel: {
            type: Object,
            required: true,
            default:() => ({})
        },

        initialSubscriptions: {
            type: Array,
            required: true,
            default: () => [],
        }
    },

    data: function() {
        return {
            subscriptions: this.initialSubscriptions
        }
    },

    computed: {
        subscribed() {
            if(!AuthUser || this.channel.user_id == AuthUser.id) return false
            return !!this.subscription
        },

        owner() {
            if(AuthUser && this.channel.user_id == AuthUser.id) return true
            return false
        },

        subscription() {
            if(!AuthUser) return null
            return this.subscriptions.find(subscription => subscription.user_id == AuthUser.id)
        },

        count() {
            return numeral(this.subscriptions.length).format('0a')
        }
    },

    methods: {
        toggleSubscription() {
            if(! AuthUser) {
                return alert('Please login to subscribe.');
            }

            if(this.owner) {
                return alert('You cannot subscribe to your channel.')
            }

            if(this.subscribed) {
                axios.delete('/channels/'+this.channel.id+'/subscriptions/'+this.subscription.id)
                    .then(() => {
                        this.subscriptions = this.subscriptions.filter(s => s.id != this.subscription.id)
                    })
            } else {
                axios.post('/channels/'+this.channel.id+'/subscriptions')
                    .then((response) => {
                        this.subscriptions = [
                            ...this.subscriptions,
                            response.data
                        ]
                })
            }
        }
    }
}
</script>
