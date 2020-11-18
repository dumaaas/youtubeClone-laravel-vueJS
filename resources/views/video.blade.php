@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if($video->editable())
                        <form action="{{route('videos.update', $video->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                    @endif
                    <div class="card-header">{{$video->title}}</div>

                    <div class="card-body">
                        <video
                            id="video"
                            class="video-js"
                            controls
                            preload="auto"
                            width="640"
                            height="268"
                            poster="{{$video->thumbnail}}"
                            data-setup="{}"
                        >
                            <source src='{{asset(\Illuminate\Support\Facades\Storage::url("videos/{$video->id}/{$video->id}.m3u8"))}}' type="application/x-mpegURL" />
                        </video>

                        <div class="d-flex justify-content-sm-between align-items-center">
                            <div>
                                <h4 class="mt-3">
                                    @if($video->editable())
                                        <input style="border:none" type="text" class="form-control" value="{{$video->title}}" name="title">
                                    @else
                                    {{$video->name}}
                                    @endif
                                </h4>
                                {{$video->views}} {{Str::plural('view', $video->views)}}
                            </div>
                            <votes :default_votes="{{$video->votes}}" entity_id="{{$video->id}}" entity_owner="{{$video->channel->user_id}}"></votes>
                        </div>
                        <hr>
                        <div>
                            @if($video->editable())
                                <textarea name="description" cols="3" rows="3" class="form-control">{{$video->description}}</textarea>
                                <div class="text-right mt-2">
                                    @if($errors->any())
                                        <ul class="list-group mb-5">
                                            @foreach($errors->all() as $error)
                                                <li class="text-danger list-group-item">
                                                    {{$error}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <button class="btn btn-info btn-sm" type="submit">Update</button>
                                </div>
                            @else
                                {{$video->description}}
                            @endif

                        </div>
                        <hr>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="media">
                            <img class="rounded-circle" src="{{$video->channel->image()}}" width="50" height="50" class="mr-3" alt="...">
                            <div class="media-body ml-2">
                                <h5 class="mt-0 mb-0">{{$video->channel->name}}</h5>
                                <span class="small">Published on {{$video->created_at->toFormattedDateString()}}</span>
                            </div>
                        </div>
                        <subscribe-button :channel="{{$video->channel}}" :initial-subscriptions="{{$video->channel->subscriptions}}">
                        </subscribe-button>
                    </div>
                        @if($video->editable())
                        </form>
                        @endif
                </div>
                <comments :video="{{$video}}"></comments>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <style>
        .video-js {
            width: 100%;
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

@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $video->id }}'
    </script>
    <script src="{{asset('js/player.js')}}"></script>
@endsection
