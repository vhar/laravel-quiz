<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * File API resource.
 *
 * @property int $id
 * @property string $url
 * @property string $originalName
 * @property string $mimeType
 * @property int $size
 * @property string $humanSize
 */
final class FileResource extends JsonResource
{
    /**
     * Transform resource into an array.
     *
     * @param Request $request Current request.
     *
     * @return array<string, mixed>
     */
    public function toArray(
        Request $request,
    ): array {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'original_name' => $this->originalName,
            'mime_type' => $this->mimeType,
            'size' => $this->size,
            'human_size' => $this->humanSize,
        ];
    }
}