<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\LaravelVideos\Models\Video;
use Vhar\Quiz\Application\Data\VideoData;

/**
 * Class VideoDataMapper
 *
 * Converts a Video model instance to its Read-Model VideoData DTO representation.
 *
 * @package Vhar\Quiz\Application\Mappers
 */
final class VideoDataMapper
{
    /**
     * Map a Video Eloquent model into VideoData.
     *
     * @param Video $video The external video Eloquent instance.
     * @return VideoData The mapped video data representation.
     */
    public function fromModel(Video $video): VideoData
    {
        return new VideoData(
            id: $video->id,
            provider: $video->provider,
            url: $video->url,
            videoId: $video->video_id,
            embedUrl: $video->embed_url,
            title: $video->title,
            thumbnail: $video->thumbnail,
            duration: $video->duration,
        );
    }
}