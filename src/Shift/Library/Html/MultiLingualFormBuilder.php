<?php
namespace Tectonic\Shift\Library\Html;

use CurrentAccount;
use Form;

class MultiLingualFormBuilder
{
    /**
     * Exact same behaviour as the normal text form builder, however it will generate numerous
     * text fields based on the number of supported languages the account has.
     *
     * @param string $name
     * @param object $model
     * @param array $options
     * @return string
     * @internal param null|string $value
     */
    public function text($name, $model, $options = array())
    {
        return $this->field('text', $name, $model, $options);
    }

    /**
     * Identical to the text method, only that it manages textarea field generation.
     *
     * @param string $name
     * @param object $model
     * @param array $options
     * @return string
     * @internal param null|string $value
     */
    public function textarea($name, $model, $options = array())
    {
        return $this->field('textarea', $name, $model, $options);
    }

    /**
     * Generates the required field via the blade template, retrieves the necessary supported langues and returns
     * the rendered HTML for the response.
     *
     * @param string $type
     * @param string $name
     * @param object $model
     * @param array $options
     * @return string
     */
    public function field($type, $name, $model, $options = array())
    {
        $supportedLanguages = CurrentAccount::get()->languages;
        $html = [];

        foreach ($supportedLanguages as $language) {
            $html[] = Form::$type("translated[{$name}][{$language->code}]", $this->getValue($name, $model, $language), $options);
        }

        return implode("\r\n", $html);
    }

    /**
     * Returns the value from a model/entity based on the name of the model's field,
     * and the language we need to render a form field for.
     *
     * @param string $name
     * @param object $model
     * @param object $language
     * @return null
     */
    protected function getValue($name, $model, $language)
    {
        if (isset($model->$name) && isset($model->{$name}[$language->code])) {
            return $model->{$name}[$language->code];
        }

        return null;
    }
}
