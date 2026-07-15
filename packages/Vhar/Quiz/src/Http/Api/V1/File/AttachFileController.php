<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Http\JsonResponse;
use Vhar\Quiz\Application\Commands\File\AttachFile\AttachFileCommand;
use Vhar\Quiz\Application\Commands\File\AttachFile\AttachFileHandler;
use Vhar\Quiz\Application\Mappers\FileDataMapper;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Http\Api\V1\File\FileResource;

/**
 * Handles file attachment to application models.
 */
final readonly class AttachFileController
{
    /**
     * Attach uploaded file to model.
     *
     * @param AttachFileRequest $request Validated request.
     * @param AttachFileHandler $handler File attachment handler.
     * @param FileDataMapper $mapper File data mapper.
     * @param ModelResolver $modelResolver Target model resolver.
     * @param EditAuthorizationResolver $resolver Model edit authorization resolver.
     *
     * @return FileResource|JsonResponse Attached file data.
     */
    public function __invoke(
        AttachFileRequest $request,
        AttachFileHandler $handler,
        FileDataMapper $mapper,
        ModelResolver $modelResolver,
        EditAuthorizationResolver $resolver,
    ): FileResource|JsonResponse {
        $model = $modelResolver->resolve(
            $request->string('model_type')->toString(),
            $request->integer('model_id'),
        );

        $resolver->authorize(
            $model,
            $request->user(),
        );

        $file = $handler->handle(
            new AttachFileCommand(
                model: $model,
                file: $request->file('file'),
            )
        );

        return new FileResource(
            $mapper->fromModel($file)
        );
    }
}