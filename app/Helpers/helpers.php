<?php
use Illuminate\Http\Resources\Json\JsonResource;
use App\Exceptions\BadRequestCustomException;

if (! function_exists('jsonResponse')) {
   
    /**
     * jsonResponse function
     *
     * @param [type] $message
     * @param [type] $data
     * @param [type] $meta
     * @param integer $code
     * @return object
     */
    function jsonResponse($message = null, $data = null, $meta = [], $success = true, $code = 200)
    {
        return response()->json([
            'success'=>$success,
            'message'=>$message,
            'data'=>$data,
            'meta'=> empty($meta) ? new stdClass : $meta,
        ],$code);
    }
}

if (! function_exists('jsonResource')) {

    /**
     * jsonResource function
     *
     * @param [type] $message
     * @param [type] $data
     * @param [type] $meta
     * @param integer $code
     * @return object
     */
    function jsonResource($message = null, JsonResource $resource, $meta = [],$success = true)
    {
        return $resource->additional([
                'success'=>$success,
                'message'=>$message,
                'meta'=>empty($meta) ? new stdClass : $meta
            ]);
    }
}


if (! function_exists('handleServiceCustomException')) {
    /**
     * @param $method
     * @param Exception $e
     * @throws BadRequestCustomException
     */
    function handleServiceCustomException($method, \Exception $e )
    {
        $message = logExceptionError($method, $e);

        throw new BadRequestCustomException($message);
    }
}



if (! function_exists('logExceptionError')) {
    /**
     * @param $method
     * @param Exception $e
     * @return string
     */
    function logExceptionError($method, \Exception $e )
    {
        Log::error($method, [
            'message' => $message = $e->getMessage(),
            'trace' => $e->getTrace()
        ]);

        return $message;
    }
}

/**
 * return active class for selected nav link
 */
if (!function_exists('classActiveSegment')) {
    function classActiveSegment($segment, $value)
    {
        if(!is_array($value)) {
            return Request::segment($segment) == $value ? 'active' : '';
        }
        foreach ($value as $v) {
            if(Request::segment($segment) == $v) return 'active';
        }
        return '';
    }
}
