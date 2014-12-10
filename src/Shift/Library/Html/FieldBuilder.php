<?php
namespace Tectonic\Shift\Library\Html;

use Illuminate\Html\FormBuilder;

class FieldBuilder
{
    /**
     * @var \Illuminate\Html\FormBuilder
     */
    protected $formBuilder;

    /**
     * @param \Illuminate\Html\FormBuilder $formBuilder
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Generate a form field dynamically
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function custom($type, $name, $value = '', $options = [])
    {
        return $this->$type($name, $value, $options);
    }

    /**
     * Generate a text input field
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function text($name, $value = '', $options = [])
    {
        return $this->formBuilder->text($name, $value, $options);
    }

    /**
     * Generate a textarea field
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function textarea($name, $value = '', $options = [])
    {
        return $this->formBuilder->textarea($name, $value, $options);
    }

    /**
     * Generate a checkbox input field
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function checkbox($name, $value, $options = [])
    {
        $checked = array_key_exists('checked', $options) ? $options['checked'] : null;

        return $this->formBuilder->checkbox($name, $value, $checked, $options);
    }

}