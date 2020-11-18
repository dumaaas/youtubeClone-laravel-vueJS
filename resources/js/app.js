import SubscribeButton from './components/SubscribeButton.vue';
import ChannelUploads from './components/ChannelUploads.vue';
import Votes from './components/Votes.vue';
import Comments from './components/Comments.vue';
import Replies from './components/Replies.vue';
import Comment from './components/Comment.vue';

require('./bootstrap');

window.numeral = require('numeral');

window.Vue = require('vue');

Vue.component('subscribe-button', SubscribeButton);
Vue.component('channel-uploads', ChannelUploads);
Vue.component('votes', Votes);
Vue.component('comments', Comments);
Vue.component('replies', Replies);
Vue.component('comment', Comment);


const app = new Vue({
    el: '#app',
});

