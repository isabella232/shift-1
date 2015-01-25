<?php
namespace Tectonic\Shift\Library\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Request;

trait Respondable
{
    /**
     * Respond with the the $data array for JSON, a partial of the view for PJAX requests,
     * or the full layout render if it's a full page request.
     *
     * @param string $view
     * @param array  $data
     *
     * @return mixed
     */
    public function respond($view, array $data = [])
    {
        if (Request::wantsJson()) {
            return $this->formatJson($data);
        }

        $this->layout->content = view($view, $data);
    }

    /**
     * Determines whether or not the request is a PJAX request.
     *
     * @return bool
     */
    public function isPjax()
    {
        return Request::header('X-PJAX') === 'true';
    }

    /**
     * Returns true if the request is for the full page.
     *
     * @return bool
     */
    public function isFullPage()
    {
        return !Request::wantsJson() && !$this->isPjax();
    }

    /**
     * Format an array or collection of variables. Basically, we want to ensure
     * an array response for the controller action for json requests.
     *
     * @param mixed $var
     * @return array
     */
    public function formatJson($var)
    {
        if (is_array($var)) {
            foreach ($var as $key => &$value) {
                if ($value instanceof Arrayable) {
                    $value = $value->toArray();
                }
            }
        }

        return $var;
    }

    /**
     * Pulled from Laravel 4. Laravel 5 completely does away with any ability to support PJAX
     * applications - we need this method as it was.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        $response = call_user_func_array(array($this, $method), $parameters);

        if (is_null($response) && ! is_null($this->layout)) {
            $response = $this->layout;
        }

        return $response;
    }
}
 