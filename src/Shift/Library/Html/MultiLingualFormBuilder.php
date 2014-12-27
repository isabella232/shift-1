<?php
namespace Tectonic\Shift\Library\Html;

use CurrentAccount;
use View;

class MultiLingualFormBuilder
{
    /**
     * Exact same behaviour as the normal text form builder, however it will generate numerous
     * text fields based on the number of supported languages the account has.
     *
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return string
     */
    public function text($name, $value = null, $options = array())
    {
        return $this->field('text', $name, $value, $options);
    }

    /**
     * Identical to the text method, only that it manages textarea field generation.
     *
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return string
     */
    public function textarea($name, $value = null, $options = array())
    {
        return $this->field('textarea', $name, $value, $options);
    }

    /**
     * Generates the required field via the blade template, retrieves the necessary supported langues and returns
     * the rendered HTML for the response.
     *
     * @param string $type
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return string
     */
    public function field($type, $name, $value = null, $options = array())
    {
        $supportedLanguages = CurrentAccount::get()->languages;

        return View::make("shift::html.form.$type", compact('name', 'value', 'options', 'supportedLanguages'));
    }
}
