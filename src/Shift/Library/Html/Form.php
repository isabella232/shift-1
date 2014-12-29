<?php 

namespace Tectonic\Shift\Library\Html;

use Illuminate\Html\FormBuilder as BaseFormBuilder;

class Form extends BaseFormBuilder 
{

    protected $modelName = null;

    /**
     * @type ParsleyConverter
     */
    public $parsley   = null;

    /**
     * @type Tectonic\Application\Validation\Validator
     */
    public $validator = null;

    /**
     * @type Laravel\Services\Translator
     */
    public $translator = null;

    /**
     * Create a new custom form builder instance.
     *
     * @param  \Illuminate\Routing\UrlGenerator  $url
     * @param  \Illuminate\Html\HtmlBuilder  $html
     * @param  string  $csrfToken
     * @return void
     */
    public function __construct( \Illuminate\Html\HtmlBuilder $html, \Illuminate\Routing\UrlGenerator $url, $csrfToken = false )
    {
        $this->url = $url;
        $this->html = $html;
        $this->csrfToken = $csrfToken ?: csrf_token();

        // Add the validator to the reserved list to ommit from attributes
        $this->reserved[] = 'validator';
    }

    /**
     * Load a validator into the form builder
     *
     * @param  mixed  $validator  Either location string or validator object instance
     * @return void
     */
    public function loadValidator( $validator )
    {
        $this->validator = $validator instanceOf Tectonic\Application\Validation\Validator ? $validator : new $validator;
    }

    /**
     * Convert laravel validation rules to parsley
     *
     * @return void
     */
    public function convertRulesToParsley()
    {
        $this->parsley = new ParsleyConvertor( $this->validator->getRules() );
    }

    /**
     * Open up a new HTML form.
     *
     * @param  array   $options
     * @return string
     */
    public function open(array $options = array())
    {
        // If we pass a validator in as an option, override any existing validator
        if( isset( $options['validator'] ) ) {
            $this->loadValidator( $options['validator'] );
        }

        // We're going to require a validator to use this builder
        if( !is_null( $this->validator ) ) {

            // Convert our validator rules to a parsley instance
            $this->convertRulesToParsley();

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
    public function model($model, array $options = []) {
        $this->setModel($model);
        return $this->open($options);
    }
    
    public function openModel($model, array $options = []) {
        return $this->model($model, $options);
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
        if( $this->parsley ) {
            $options = array_merge( $options, $this->parsley->getFieldRules($name) ); 
        }

        return parent::input($type, $name, $value, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function textarea($name, $value = null, $options = [])
    {
        if( $this->parsley ) {
            $options = array_merge( $options, $this->parsley->getFieldRules($name) ); 
        }

        return parent::textarea($name, $value, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function select($name, $list = [], $selected = null, $options = [])
    {
        if( $this->parsley ) {
            $options = array_merge( $options, $this->parsley->getFieldRules($name) ); 
        }

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