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
     * Generate a date field. This basically an alias for the text field
     * (instead of a HTML5 date field), so browser compatibility isn't an issue.
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function date($name, $value = '', $options = [])
    {
        return $this->text($name, $value, $options);
    }

    /**
     * Generate a time field. This basically an alias for the text field
     * (instead of a HTML5 time field), so browser compatibility isn't an issue.
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function time($name, $value = '', $options = [])
    {
        return $this->text($name, $value, $options);
    }

    /**
     * Generate a datetime field. This basically an alias for the text field
     * (instead of a HTML5 datetime field), so browser compatibility isn't an issue.
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function datetime($name, $value = '', $options = [])
    {
        return $this->text($name, $value, $options);
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
    public function checkbox($name, $value = null, $options = [])
    {
        $checked = ($value == 1 || $value == true) ? true : null;

        return $this->formBuilder->checkbox($name, 1, $checked, $options);
    }

    /**
     * Generate a select field.
     *
     * @param        $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function select($name, $value = null, $options = [])
    {
        $select_options = [];

        // Loop through, and pluck out the select box list options
        // from the $options array, then remove the select options.
        foreach($options as $key => $label)
        {
            if(is_array($label))
            {
                $select_options = $label;
                unset($options[$key]);
            }
        }

        return $this->formBuilder->select($name, $select_options, $value, $options);
    }

    public function file()
    {
        // TODO: Generate file input field
    }

    public function multiselect()
    {
        // TODO: Generate multi-select field
    }
}