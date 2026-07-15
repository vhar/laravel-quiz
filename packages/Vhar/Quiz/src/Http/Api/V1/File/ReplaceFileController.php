<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Http\JsonResponse;
use Vhar\Quiz\Application\Commands\File\ReplaceFile\ReplaceFileCommand;
use Vhar\Quiz\Application\Commands\File\ReplaceFile\ReplaceFileHandler;
use Vhar\Quiz\Application\Mappers\FileDataMapper;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\FileResolver;
use Vhar\Quiz\Application\Services\ModelResolver;

/**
 * Handles file replacement requests.
 */
final readonly class ReplaceFileController
{
    /**
     * Replace existing file.
     *
     * @param ReplaceFileRequest $request Validated replace file request.
     * @param ReplaceFileHandler $handler Replace file handler.
     * @param ModelResolver $modelResolver Target model resolver.
     * @param FileResolver $fileResolver File attachment resolver.
     * @param EditAuthorizationResolver $authorizationResolver Edit authorization resolver.
     * @param FileDataMapper $mapper File data mapper.
     * @param int $fileId Existing file identifier.
     *
     * @return FileResource|JsonResponse
     */
    public function __invoke(
        ReplaceFileRequest $request,
        ReplaceFileHandler $handler,
        ModelResolver $modelResolver,
        FileResolver $fileResolver,
        EditAuthorizationResolver $authorizationResolver,
        FileDataMapper $mapper,
        int $fileId,
    ): FileResource|JsonResponse {
        $model = $modelResolver->resolve(
            $request->string('model_type')->toString(),
            $request->integer('model_id'),
        );

        $authorizationResolver->authorize(
            $model,
            $request->user(),
        );

        $file = $fileResolver->resolve(
            $model,
            $fileId,
        );

        $file = $handler->handle(
            new ReplaceFileCommand(
                file: $file,
                newFile: $request->file('file'),
            )
        );

        return new FileResource(
            $mapper->fromModel($file)
        );
    }
}