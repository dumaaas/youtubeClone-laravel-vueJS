<template>
        <div class="col-md-8">
            <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
<!--                <i onclick="document.getElementById('video-files').click()" style="color:red; width:70px; height: 70px" class="fab fa-youtube"></i>-->
                <p class="text-center">Upload Videos</p>
                <input type="file" multiple id="video-files" ref="videos"  @change="upload">
            </div>
            <div class="card p-3" v-else>
                <div class="my-4" v-for="video in videos" :key="video">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: (video.percentage || progress[video.name])+'%'}">
                            {{ video.percentage ? video.percentage == 100 ? 'Video processing completed.' :  'Processing' : 'Uploading'}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center" style="height: 180px; color:white; font-size: 18px; background:#808080;">
                                Loading thumbnail ...
                            </div>
                            <img v-else :src="video.thumbnail" style="width: 150px; height:180px;" alt="">
                        </div>
                        <div class="col-md-4">
                            <a v-if="video.percentage && video.percentage == 100" target="_blank" :href="'/videos/'+video.id">
                                {{video.title}}
                            </a>
                            <p v-else class="text-center">
                                {{ video.title || video.name}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {

    props: {
        channel: {
            type: Object,
            required: true,
            default:() => ({})
        }
    },

    data: () => ({
        selected: false,
        videos: [],
        progress: {},
        uploads: [],
        intervals: {},
    }),

    methods: {
        upload() {
            this.selected = true
            this.videos = Array.from(this.$refs.videos.files)
            const uploaders = this.videos.map(video => {
                const form = new FormData()

                this.progress[video.name] = 0

                form.append('video', video)
                form.append('title', video.name)

                return axios.post('/channels/'+this.channel.id+'/videos', form, {
                    onUploadProgress: (event) => {
                        this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)

                        this.$forceUpdate()
                    }
                }).then(({data}) => {
                    this.uploads = [
                        ...this.uploads,
                        data
                    ]
                })
            })

            axios.all(uploaders).then(() => {

                this.videos = this.uploads
                this.videos.forEach(video => {
                    this.intervals[video.id] = setInterval(() => {
                        axios.get('/videos/'+video.id).then(({data}) => {
                            if(data.percentage==100) {
                                clearInterval(this.intervals[video.id])
                            }
                            this.videos = this.videos.map(v => {
                                if(v.id==data.id) {
                                    return data
                                }
                                return v
                            })
                        })
                    }, 3000)
                })
            })
        }
    },
}
</script>
