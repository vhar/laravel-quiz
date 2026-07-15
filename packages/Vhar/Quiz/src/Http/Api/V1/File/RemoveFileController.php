<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Vhar\Quiz\Application\Commands\File\RemoveFile\RemoveFileCommand;
use Vhar\Quiz\Application\Commands\File\RemoveFile\RemoveFileHandler;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\FileResolver;
use Vhar\Quiz\Application\Services\ModelResolver;

final readonly class RemoveFileController
{
    /**
     * Remove file from model.
     *
     * @param RemoveFileRequest $request Validated remove file request.
     * @param RemoveFileHandler $handler File removal handler.
     * @param ModelResolver $modelResolver Target model resolver.
     * @param FileResolver $fileResolver Attached file resolver.
     * @param EditAuthorizationResolver $resolver Model edit authorization resolver.
     *
     * @return Response|JsonResponse
     */
    public function __invoke(
        RemoveFileRequest $request,
        RemoveFileHandler $handler,
        ModelResolver $modelResolver,
        FileResolver $fileResolver,
        EditAuthorizationResolver $resolver,
        int $fileId,
    ): Response|JsonResponse {
        $model = $modelResolver->resolve(
            $request->string('model_type')->toString(),
            $request->integer('model_id'),
        );

        $resolver->authorize(
            $model,
            $request->user(),
        );

        $file = $fileResolver->resolve(
            $model,
            $fileId,
        );

        $handler->handle(
            new RemoveFileCommand(
                model: $model,
                file: $file,
            )
        );

        return response()->noContent();
    }
}