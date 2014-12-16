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
        return $this->textField('text', $name, $value, $options);
    }

    /**
     * Identical to the text method, only it manages textarea field generation.
     *
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return string
     */
    public function textarea($name, $value = null, $options = array())
    {
        return $this->textField('textarea', $name, $value, $options);
    }

    /**
     * @param string $type
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return string
     */
    public function textField($type, $name, $value = null, $options = array())
    {
        $supportedLanguages = CurrentAccount::get()->languages;

        return View::make("shift::html.form.$type", compact('name', 'value', 'options', 'supportedLanguages'));
    }
}
