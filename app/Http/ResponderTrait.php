<?php
/**
 * Name: ResponderTrait.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Http;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as Statuses;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

/**
 * Class ResponderTrait
 *
 * @package Rcs\Bot\Http
 */
trait ResponderTrait
{
    /**
     * @param array|Collection|Model|Fractal $data
     * @param TransformerAbstract            $transformer
     *
     * @return JsonResponse
     */
    protected function respondOk($data, TransformerAbstract $transformer): JsonResponse
    {
        return $this->respondFractal($data, $transformer);
    }

    /**
     * @param array|Collection|Model|Fractal $data
     * @param TransformerAbstract            $transformer
     *
     * @return JsonResponse
     */
    protected function respondCreated($data, TransformerAbstract $transformer): JsonResponse
    {
        return $this->respondFractal($data, $transformer, Statuses::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    protected function respondNoContent(): JsonResponse
    {
        return response()
            ->json(null, Statuses::HTTP_NO_CONTENT);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function respondForbidden(array $data = [])
    {
        return $this->respond($data, Statuses::HTTP_FORBIDDEN);
    }

    /**
     * @param array|Collection|Model|Fractal $data
     * @param TransformerAbstract            $transformer
     * @param int                            $status
     *
     * @return JsonResponse
     */
    protected function respondFractal($data, TransformerAbstract $transformer, int $status = Statuses::HTTP_OK): JsonResponse
    {
        $processedData = $this->processDataWithFractal($data, $transformer);

        return $this->respond($processedData->toArray(), $status);
    }

    /**
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    protected function respond(array $data, int $status = Statuses::HTTP_OK): JsonResponse
    {
        return response()
            ->json($data, $status);
    }

    /**
     * @param array|Collection|Model|Fractal $data
     * @param TransformerAbstract            $transformer
     *
     * @return Fractal
     */
    protected function processDataWithFractal($data, TransformerAbstract $transformer): Fractal
    {
        if ($data instanceof Fractal) {
            return $data;
        }

        $fractal = fractal();
        if (is_array($data) || $data instanceof Collection) {
            $fractal->collection($data, $transformer);
        } else {
            $fractal->item($data, $transformer);
        }

        return $fractal;
    }
}
