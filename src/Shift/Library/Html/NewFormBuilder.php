<?php 

namespace Tectonic\Shift\Library\Html;

use Illuminate\Html\FormBuilder as BaseFormBuilder;

class NewFormBuilder extends BaseFormBuilder 
{

    protected $modelName = null;

    /**
     * @type ParsleyConverter
     */
    protected $parsley   = null;

    /**
     * Create a new custom form builder instance.
     *
     * @param  \Illuminate\Routing\UrlGenerator  $url
     * @param  \Illuminate\Html\HtmlBuilder  $html
     * @param  string  $csrfToken
     * @return void
     */
    public function __construct(\Illuminate\Html\HtmlBuilder $html, \Illuminate\Routing\UrlGenerator $url, $csrfToken = false )
    {
        $this->url = $url;
        $this->html = $html;
        $this->csrfToken = csrf_token();

        // Add the validator to the reserved list to ommit from attributes
        $this->reserved[] = 'validator';
    }

    /**
     * Open up a new HTML form.
     *
     * @param  array   $options
     * @return string
     */
    public function open(array $options = array())
    {
        // We're going to require a validator to use this builder
        if( $options['validator'] ) {

            // Create new instance of validator
            $validator = new $options['validator'];

            // Set up new parsley convertor using validators rules
            $this->parsley = new ParsleyConvertor( $validator->getRules() );

            $method = array_get($options, 'method', 'post');

            // We need to extract the proper method from the attributes. If the method is
            // something other than GET or POST we'll use POST since we will spoof the
            // actual method since forms don't support the reserved methods in HTML.
            $attributes['method'] = $this->getMethod($method);

            $attributes['action'] = $this->getAction($options);

            $attributes['accept-charset'] = 'UTF-8';

            // If the method is PUT, PATCH or DELETE we will need to add a spoofer hidden
            // field that will instruct the Symfony request to pretend the method is a
            // different method than it actually is, for convenience from the forms.
            $append = $this->getAppendage($method);

            if (isset($options['files']) && $options['files'])
            {
                $options['enctype'] = 'multipart/form-data';
            }

            // Finally we're ready to create the final form HTML field. We will attribute
            // format the array of attributes. We will also add on the appendage which
            // is used to spoof requests for this PUT, PATCH, etc. methods on forms.
            $attributes = array_merge(

                $attributes, array_except($options, $this->reserved)

            );

            // Push validator attribute into form tag manually
            array_push( $attributes, 'data-parsley-validate' );

            // Finally, we will concatenate all of the attributes into a single string so
            // we can build out the final form open statement. We'll also append on an
            // extra value for the hidden _method field if it's needed for the form.
            $attributes = $this->html->attributes($attributes);

            return '<form'.$attributes.'>'.$append;
        }

        else {
            return BaseFormBuilder::open( $options );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function label($name, $value = null, $options = []) {
        $this->labels[] = $name;

        $options = $this->html->attributes($options);

        $value = e($this->formatLabel($name, $value));

        $for = ($this->modelName && !starts_with($name, '_')) ? $this->modelName.'-'.$name : $name;

        return '<label for="'.$for.'"'.$options.'>'.$value.'</label>';
    }

    /**
     * Create a Bootstrap-like help block.
     *
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function helpBlock($value, array $options = []) {
        if (isset($options['class'])) {
            $options['class'] = 'help-block '.$options['class'];
        } else {
            $options['class'] = 'help-block';
        }

        return '<span'.$this->html->attributes($options).'>'.$value.'</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function input($type, $name, $value = null, $options = [])
    {
        $options = array_merge($options, $this->parsley->getFieldRules($name));

        return parent::input($type, $name, $value, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function textarea($name, $value = null, $options = [])
    {
        $options = array_merge($options, $this->parsley->getFieldRules($name));

        return parent::textarea($name, $value, $options);
    }

    public function select($name, $list = [], $selected = null, $options = [])
    {
        $options = array_merge($options, $this->parsley->getFieldRules($name));

        return parent::select($name, $list, $selected, $options);
    }

    public function setModel($model) {
        $this->model = $model;
        $this->modelName = strtolower((new \ReflectionClass($this->model))->getShortName());
    }

    /**
     * Gets the short model name.
     *
     * @return string
     */
    public function getModelName() {
        return $this->modelName;
    }

    public function name() {
        return $this->getModelName();
    }
}