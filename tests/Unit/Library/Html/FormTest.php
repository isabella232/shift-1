<?php namespace Tests\Unit\Library\Html;

use Mockery as m;
use Tests\UnitTestCase;
use Illuminate\Http\Request;
use Tectonic\Shift\Library\Html\Form as FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Routing\RouteCollection;


class FormTest extends UnitTestCase
{
    /**
     * Setup the test environment.
     */
    public function init()
    {
        $this->urlGenerator = new UrlGenerator( new RouteCollection, Request::create('/foo', 'GET') );
        $this->htmlBuilder = new HtmlBuilder( $this->urlGenerator );
        $this->formBuilder = new FormBuilder( $this->htmlBuilder, $this->urlGenerator, 123 );

        // Create mock instance of validator class
        $validator = m::mock( 'Tectonic\Application\Validation\Validator' );

        // Set up some basic validation rules that should be used for
        // all validation tests
        $validator->shouldReceive('getRules')
            ->andReturn([
                'name' => 'required',
                'email' => 'email',
                'textarea' => 'required',
                'select' => 'required'
            ]);

        // 
        $this->formBuilder->validator = $validator;
        $this->formBuilder->convertRulesToParsley();
    }

    public function testOpenNewForm()
    {
        // Run basic formbuilder for get, for some reason any post, put etc with hidden fields gets parsed into parsley (no idea why or how)
        $form1 = $this->formBuilder->open([ 'method' => 'GET' ]);
        $this->assertEquals('<form method="GET" action="http://localhost/foo" accept-charset="UTF-8" data-parsley-validate="data-parsley-validate">', $form1);
    }

    public function testTextInput()
    {

        $translator = M::mock( 'Laravel\Services\Translator' );

        $translator->shouldReceive( 'get' )
            ->with( '' )
            ->andReturn( $expected );


        $form1 = $this->formBuilder->input('text', 'name');
        $this->assertEquals('<input data-parsley-required="" data-parsley-required-message="The name field is required." data-parsley-pattern="/^[a-zа-яё]+$/i" data-parsley-pattern-message="The name may only contain letters." name="name" type="text">', $form1);
    }

    public function testEmailInput()
    {
        $form1 = $this->formBuilder->email('email');

        $this->assertEquals('<input data-parsley-required="" data-parsley-required-message="The name field is required." data-parsley-pattern="/^[a-zа-яё]+$/i" data-parsley-pattern-message="The name may only contain letters." name="name" type="text">', $form1);
    }
}