<?php

namespace Vhar\Quiz\Application\Data;

/**
 * Class VideoData
 *
 * Data Transfer Object representing normalized external video details.
 *
 * @package Vhar\Quiz\Application\Data
 */
final readonly class VideoData
{
    /**
     * VideoData constructor.
     *
     * @param int $id Unique identifier of the video record.
     * @param string $provider The provider name (e.g., youtube).
     * @param string $url The original video URL.
     * @param string|null $videoId Extracted unique identifier from the service.
     * @param string|null $embedUrl Generated iframe-embeddable URL.
     * @param string|null $title Title of the external video.
     * @param string|null $thumbnail Image preview URL.
     * @param int|null $duration Duration in seconds.
     */
    public function __construct(
        public int $id,
        public string $provider,
        public string $url,
        public ?string $videoId = null,
        public ?string $embedUrl = null,
        public ?string $title = null,
        public ?string $thumbnail = null,
        public ?int $duration = null,
    ) {
    }
}