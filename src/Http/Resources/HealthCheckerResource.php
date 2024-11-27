<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Larakek\HealthCheck\ErrorBag;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckerResource extends JsonResource
{
    /**
     * {@inheritdoc}
     *
     * @var ErrorBag
     */
    public $resource;

    /**
     * {@inheritdoc}
     */
    public static $wrap = null;

    /**
     * {@inheritDoc}
     */
    public function __construct(ErrorBag $result)
    {
        parent::__construct($result);
    }

    /**
     * {@inheritdoc}
     */
    public function toResponse($request): JsonResponse
    {
        return (new ResourceResponse($this))
            ->toResponse($request)
            ->setStatusCode(
                $this->resource->hasFailed()
                ? Response::HTTP_I_AM_A_TEAPOT
                : Response::HTTP_OK,
            );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        $data = ['message' => 'ok'];
        if ($this->resource->hasFailed()) {
            $data['message'] = 'ne ok';
            $data['errors'] = $this->resource->getErrors();
        }

        return $data;
    }
}
