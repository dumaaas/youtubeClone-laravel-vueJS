<?php

namespace App\Http\Controllers;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote($entityId, $type) {
        $entity = $this->getEntity($entityId);
        return auth()->user()->toggleVote($entity, $type);
    }

    public function getEntity($entityId) {
        $video = Video::find($entityId);
        if($video) return $video;
        $comment = Comment::find($entityId);
        if($comment) return $comment;
        throw new ModelNotFoundException('Entity not found.');
    }
}
